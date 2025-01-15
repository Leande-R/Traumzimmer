<?php
session_start();
require 'dbaccess.php';

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: not_logged_in.php');
    exit;
}



// Angenommene POST-Parameter: $zimmer (z.B. 'Doppelzimmer Premium')
// Holen wir uns die verfügbaren Zimmer der angegebenen Kategorie:
$zimmerbezeichnung = $_GET['zimmer']; // z.B. 'Doppelzimmer Premium'

// SQL Query, um freie Zimmer der Kategorie abzurufen
$sql = "
    SELECT zimmerid
    FROM zimmer
    WHERE bezeichnung = :zimmerbezeichnung
    AND zimmerid NOT IN (
        SELECT zimmerid
        FROM reservierungen
        WHERE (anreisedatum BETWEEN :checkin AND :checkout) 
        OR (abreisedatum BETWEEN :checkin AND :checkout)
        OR (anreisedatum <= :checkin AND abreisedatum >= :checkout)
    )
    ORDER BY zimmerid ASC"; // Zimmer nach zimmerid aufsteigend sortieren

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':checkin' => $checkin,
    ':checkout' => $checkout
]);

// Holen der freien Zimmer
$freieZimmer = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prüfen, wie viele Zimmer verfügbar sind:
if (count($freieZimmer) > 0) {
    // Falls mindestens ein Zimmer frei ist, nimm das Zimmer mit der kleineren zimmerid
    $zimmerid = $freieZimmer[0]['zimmerid']; // Kleineres Zimmer wird durch die SQL-Sortierung gewährleistet
    // Weiterverarbeitung: Reservierung vornehmen

    
} else {
    echo "Leider sind keine Zimmer verfügbar für den gewählten Zeitraum.";
}


// Handle GET parameters
$guests = isset($_GET['guests']) ? htmlspecialchars($_GET['guests']) : '';
$checkin = isset($_GET['checkin']) ? htmlspecialchars($_GET['checkin']) : '';
$checkout = isset($_GET['checkout']) ? htmlspecialchars($_GET['checkout']) : '';

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
    <form method="post" action="reservationconfirmation.php">
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
            <p class="form-control-static"><?= htmlspecialchars($zimmer) ?></p>
        </div>
        <div class="mb-3">
            <label class="form-label">Wünschen Sie unser exquisites Frühstück in Anspruch zu nehmen?</label>
            <div>
                <input type="radio" id="breakfast_yes" name="breakfast" value="yes" required>
                <label for="breakfast_yes">Ja</label>
                <input type="radio" id="breakfast_no" name="breakfast" value="no" required>
                <label for="breakfast_no">Nein</label>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Benötigen Sie einen Parkplatz?</label>
            <div>
                <input type="radio" id="parking_yes" name="parking" value="yes" required>
                <label for="parking_yes">Ja</label>
                <input type="radio" id="parking_no" name="parking" value="no" required>
                <label for="parking_no">Nein</label>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Reisen Sie mit Ihrem geliebten vierbeinigem Freund?</label>
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
