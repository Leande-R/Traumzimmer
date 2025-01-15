<?php
session_start();
require 'dbaccess.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: not_logged_in.php');
    exit;
}

// Sicherstellen, dass die E-Mail-Adresse in der Session existiert
if (!isset($_SESSION['email'])) {
    echo "E-Mail-Adresse ist nicht in der Session gesetzt.";
    exit;
}

$user_email = $_SESSION['email'];

// Query, um alle Reservierungen und die Zimmerbezeichnung zu erhalten
$sql = "SELECT 
            r.reservationsid, 
            r.zimmerid, 
            z.bezeichnung AS zimmer_bezeichnung, 
            r.gaeste, 
            r.anreisedatum, 
            r.abreisedatum, 
            r.reservierungsdatum, 
            r.fruehstueck, 
            r.parkplatz, 
            r.haustier, 
            r.gesamtpreis, 
            r.status 
        FROM reservierungen r
        JOIN zimmer z ON r.zimmerid = z.zimmerid
        WHERE r.mailadresse = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('s', $user_email);
$stmt->execute();
$result = $stmt->get_result();

$reservations = [];
while ($row = $result->fetch_assoc()) {
    $row['anreisedatum'] = date('d.m.Y', strtotime($row['anreisedatum']));
    $row['abreisedatum'] = date('d.m.Y', strtotime($row['abreisedatum']));
    $row['reservierungsdatum'] = date('d.m.Y', strtotime($row['reservierungsdatum']));
    $reservations[] = $row;
}
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meine Reservierungen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <h1>Meine Reservierungen</h1>

    <?php if (empty($reservations)): ?>
        <p class="text-muted">Sie haben bisher keine Reservierungen.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Reservierungs-ID</th>
                        <th>Zimmer</th>
                        <th>Gäste</th>
                        <th>Anreisedatum</th>
                        <th>Abreisedatum</th>
                        <th>Reservierungsdatum</th>
                        <th>Frühstück</th>
                        <th>Parkplatz</th>
                        <th>Haustier</th>
                        <th>Gesamtpreis (€)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $reservation): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($reservation['reservationsid']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['zimmer_bezeichnung']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['gaeste']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['anreisedatum']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['abreisedatum']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['reservierungsdatum']); ?></td>
                            <td><?php echo $reservation['fruehstueck'] ? 'Ja' : 'Nein'; ?></td>
                            <td><?php echo $reservation['parkplatz'] ? 'Ja' : 'Nein'; ?></td>
                            <td><?php echo $reservation['haustier'] ? 'Ja' : 'Nein'; ?></td>
                            <td><?php echo number_format($reservation['gesamtpreis'], 2, ',', '.'); ?></td>
                            <td class="<?php 
                                echo $reservation['status'] === 0 ? 'status-neu' : 
                                     ($reservation['status'] === 1 ? 'status-bestaetigt' : 'status-storniert'); ?>">
                                <?php 
                                echo $reservation['status'] === 0 ? 'Neu' : 
                                     ($reservation['status'] === 1 ? 'Bestätigt' : 'Storniert'); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
