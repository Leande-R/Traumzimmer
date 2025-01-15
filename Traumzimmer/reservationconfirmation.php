<?php
session_start();
require 'dbaccess.php';

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: not_logged_in.php');
    exit;
}

// Holen der Reservierungs-ID aus der URL, um die Reservierungsdetails anzuzeigen
$reservationId = isset($_GET['reservation_id']) ? intval($_GET['reservation_id']) : 0;

if ($reservationId === 0) {
    // Falls keine gültige Reservierungs-ID übergeben wurde, abbrichen.
    echo "Fehler: Keine Reservierung gefunden.";
    exit;
}

// SQL Query, um die Details der Reservierung zu holen
$sql = "SELECT r.reservierungsdatum, r.anreisedatum, r.abreisedatum, r.gaeste, 
                z.bezeichnung AS zimmerbezeichnung, r.gesamtpreis, r.fruehstueck, r.parkplatz, r.haustier
        FROM reservierungen r
        JOIN zimmer z ON r.zimmerid = z.zimmerid
        WHERE r.reservationsid = ? AND r.mailadresse = ?"; // Anpassen der Spalte zu 'reservationsid'

$stmt = $mysqli->prepare($sql);
$stmt->bind_param('is', $reservationId, $_SESSION['email']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Details holen
    $reservation = $result->fetch_assoc();
} else {
    echo "Keine Reservierungsdetails gefunden.";
    exit;
}


?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reservierungsbestätigung</title>
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
    <h1 class="text-center">Reservierungsbestätigung</h1>
    
    <p class="text-center">Vielen Dank für Ihre Reservierung! Hier sind die Details:</p>
    
    <table class="table table-light">
        <thead>
            <tr>
                <th scope="col">Buchungsdetails</th>
                <th scope="col">Ihre Angaben</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Reservierungsdatum</td>
                <td><?= date('d.m.Y', strtotime($reservation['reservierungsdatum'])) ?></td>
            </tr>
            <tr>
                <td>Zimmerbezeichnung</td>
                <td><?= htmlspecialchars($reservation['zimmerbezeichnung']) ?></td>
            </tr>
            <tr>
                <td>Anreisedatum</td>
                <td><?= date('d.m.Y', strtotime($reservation['anreisedatum'])) ?></td>
            </tr>
            <tr>
                <td>Abreisedatum</td>
                <td><?= date('d.m.Y', strtotime($reservation['abreisedatum'])) ?></td>
            </tr>
            <tr>
                <td>Gäste</td>
                <td><?= $reservation['gaeste'] ?> Person(en)</td>
            </tr>
            <tr>
                <td>Frühstück</td>
                <td><?= $reservation['fruehstueck'] ? 'Ja' : 'Nein' ?></td>
            </tr>
            <tr>
                <td>Parkplatz</td>
                <td><?= $reservation['parkplatz'] ? 'Ja' : 'Nein' ?></td>
            </tr>
            <tr>
                <td>Haustier</td>
                <td><?= $reservation['haustier'] ? 'Ja' : 'Nein' ?></td>
            </tr>
            <tr class="table-success">
                <td><strong>Gesamtpreis</strong></td>
                <td><strong><?= number_format($reservation['gesamtpreis'], 2, ',', '.') ?> €</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="alert alert-success mt-3" role="alert">
        Ihre Reservierung wurde erfolgreich abgeschlossen. Wir freuen uns, Sie bald begrüßen zu dürfen!
    </div>

    <div class="text-center mt-3">
        <a href="index.php" class="btn btn-primary">Zurück zur Startseite</a>
    </div>

</div>

<!-- Footer -->
<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
