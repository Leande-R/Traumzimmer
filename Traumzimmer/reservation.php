<?php
session_start();
require 'dbaccess.php';

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: not_logged_in.php');
    exit;
}



$zimmerbezeichnung = $_GET['zimmer']; // z.B. 'Doppelzimmer Premium'
$guests = isset($_GET['guests']) ? intval($_GET['guests']) : 1;
$checkin = isset($_GET['checkin']) ? htmlspecialchars($_GET['checkin']) : '';
$checkout = isset($_GET['checkout']) ? htmlspecialchars($_GET['checkout']) : '';


// SQL Abfrage, um freie Zimmer der Kategorie abzurufen
$sql = "
    SELECT zimmerid, preispronacht
    FROM zimmer
    WHERE bezeichnung = ? 
    AND zimmerid NOT IN (
        SELECT zimmerid
        FROM reservierungen
        WHERE (anreisedatum BETWEEN ? AND ?)
        OR (abreisedatum BETWEEN ? AND ?)
        OR (anreisedatum <= ? AND abreisedatum >= ?)
    )
    ORDER BY zimmerid ASC"; 

$stmt = $mysqli->prepare($sql);


$stmt->bind_param('sssssss', $zimmerbezeichnung, $checkin, $checkout, $checkin, $checkout, $checkin, $checkout);
$stmt->execute();
$result = $stmt->get_result();

// Holen der freien Zimmer
$freieZimmer = $result->fetch_all(MYSQLI_ASSOC);

// Prüfen, ob Zimmer verfügbar sind:
if (count($freieZimmer) > 0) {
    // Wenn mindestens ein Zimmer verfügbar ist, wählen wir das Zimmer mit der kleineren ZimmerID
    $zimmerid = $freieZimmer[0]['zimmerid'];  // Kleineres Zimmer durch SQL-Sortierung
    $zimmerPreis = $freieZimmer[0]['preispronacht'];  // Preis pro Nacht
} else {
    $sql = "
    SELECT zimmerid, preispronacht
    FROM zimmer
    WHERE bezeichnung = ? 
    AND zimmerid NOT IN (
        SELECT zimmerid
        FROM reservierungen
        WHERE (
            (anreisedatum BETWEEN ? AND ?)
            OR (abreisedatum BETWEEN ? AND ?)
            OR (anreisedatum <= ? AND abreisedatum >= ?)
        )
    )
    ORDER BY zimmerid ASC";

$stmt = $mysqli->prepare($sql);

// Bind-Parameter: 's' für string (zimmerbezeichnung), 's' für datumswerte (checkin, checkout) 
// Stellen Sie sicher, dass die Variablen korrekt sind und den erwarteten Datentypen entsprechen
$stmt->bind_param('sssssss', $zimmerbezeichnung, $checkin, $checkout, $checkin, $checkout, $checkin, $checkout);
$stmt->execute();
$result = $stmt->get_result();

// Holen der freien Zimmer
$freieZimmer = $result->fetch_all(MYSQLI_ASSOC);

// Prüfen, ob Zimmer verfügbar sind:
if (count($freieZimmer) > 0) {
    // Wenn mindestens ein Zimmer verfügbar ist, wählen wir das Zimmer mit der kleineren ZimmerID
    $zimmerid = $freieZimmer[0]['zimmerid'];  // Kleineres Zimmer durch SQL-Sortierung
    $zimmerPreis = $freieZimmer[0]['preispronacht'];  // Preis pro Nacht
} else {
    echo "Leider sind keine Zimmer verfügbar für den gewählten Zeitraum.";
    exit;
}
    exit;
}



// Wenn das Formular über POST abgeschickt wurde (Reservierung durchführen)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Zusatzinformationen vom Formular:
    $breakfast = isset($_POST['breakfast']) && $_POST['breakfast'] === 'yes' ? 1 : 0;
    $parking = isset($_POST['parking']) && $_POST['parking'] === 'yes' ? 1 : 0;
    $pets = isset($_POST['pets']) && $_POST['pets'] === 'yes' ? 1 : 0;

    // Zusatzkosten für die Addons:
    $breakfastPrice = $breakfast ? 45 : 0; // Frühstückskosten: 45€
    $parkingPrice = $parking ? 30 : 0;     // Parkplatzkosten: 30€
    $petsPrice = $pets ? 15 : 0;           // Haustierkosten: 15€

    // Berechnung der Dauer des Aufenthalts (in Nächten)
    $nights = (strtotime($checkout) - strtotime($checkin)) / 86400;  // 86400 Sekunden in einem Tag
    $totalRoomPrice = $zimmerPreis * $nights;  // Gesamtkosten für das Zimmer
    
    // Gesamtpreis berechnen
    $totalPrice = $totalRoomPrice + $breakfastPrice + $parkingPrice + $petsPrice;

    // Reservierung in die Datenbank einfügen
    $reservierungsdatum = date('Y-m-d H:i:s');
    $mailadresse = $_SESSION['email']; // Benutzer-E-Mail aus der Session
    $stmt = $mysqli->prepare("INSERT INTO reservierungen (mailadresse, zimmerid, gaeste, anreisedatum, abreisedatum, reservierungsdatum, fruehstueck, parkplatz, haustier, gesamtpreis, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $status = 0; 
    
    $stmt->bind_param('siissssiiis', $mailadresse, $zimmerid, $guests, $checkin, $checkout, $reservierungsdatum, $breakfast, $parking, $pets, $totalPrice, $status);
    if ($stmt->execute()) {
        $reservationId = $mysqli->insert_id;

        $reservationSuccess = true; // Erfolgreiche Reservierung
        header("Location: reservationconfirmation.php?reservation_id=" . $reservationId);
        exit;
    } else {
        echo "Fehler bei der Reservierung. Bitte versuchen Sie es später noch einmal.";
    }
}



?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reservierung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        body {
            background: url('images/Hotel4_3.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }
        .content-wrapper {
            flex: 1;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        footer {
            background-color: #343a40;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container content-wrapper">
    <h1 class="text-center">Reservierung</h1>

    <?php if (isset($reservationSuccess) && $reservationSuccess): ?>
        <div class="alert alert-success" role="alert">
            Ihre Reservierung war erfolgreich! Sie erhalten in Kürze eine Bestätigungs-E-Mail.
        </div>
    <?php endif; ?>


    <form method="post" >
        <div class="mb-3">
            <label for="guests" class="form-label">Anzahl der Gäste:</label>
            <!-- Nur den Wert der Gäste anzeigen -->
            <p class="form-control-static"><?= htmlspecialchars($guests) ?></p>
        </div>
        
        <div class="mb-3">
        <label for="checkin" class="form-label">Anreisedatum:</label>
        <!-- Anreisedatum im Format DD.MM.YYYY anzeigen -->
        <p class="form-control-static"><?= date('d.m.Y', strtotime($checkin)) ?></p>
    </div>
    
    <div class="mb-3">
        <label for="checkout" class="form-label">Abreisedatum:</label>
        <!-- Abreisedatum im Format DD.MM.YYYY anzeigen -->
        <p class="form-control-static"><?= date('d.m.Y', strtotime($checkout)) ?></p>
    </div>
        
        <div class="mb-3">
            <label for="zimmer" class="form-label">Zimmer:</label>
            <!-- Den Zimmertyp als Text anzeigen -->
            <p class="form-control-static"><?= htmlspecialchars($zimmerbezeichnung) ?></p>
            </div>
        <div class="mb-3">
            <label class="form-label">Wünschen Sie unser exquisites Frühstück in Anspruch zu nehmen? +45€</label>
            <div>
                <input type="radio" id="breakfast_yes" name="breakfast" value="yes" required>
                <label for="breakfast_yes">Ja</label>
                <input type="radio" id="breakfast_no" name="breakfast" value="no" required>
                <label for="breakfast_no">Nein</label>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Benötigen Sie einen Parkplatz? +30€</label>
            <div>
                <input type="radio" id="parking_yes" name="parking" value="yes" required>
                <label for="parking_yes">Ja</label>
                <input type="radio" id="parking_no" name="parking" value="no" required>
                <label for="parking_no">Nein</label>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Reisen Sie mit Ihrem geliebten vierbeinigem Freund? +15€</label>
            <div>
                <input type="radio" id="pets_yes" name="pets" value="yes" required>
                <label for="pets_yes">Ja</label>
                <input type="radio" id="pets_no" name="pets" value="no" required>
                <label for="pets_no">Nein</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Reservieren</button>
    </form>
</div>

<!-- Footer -->
<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
