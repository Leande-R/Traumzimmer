<?php
session_start();
require 'dbaccess.php';

$isAdmin = false;
if (isset($_SESSION['email'])) {
    $email = $mysqli->real_escape_string($_SESSION['email']);
    $query = "SELECT admin FROM users WHERE mailadresse = ?";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['admin'] == 1) {
                $isAdmin = true;
            }
        }
    }
}

if (!$isAdmin) {
    header('Location: not_logged_in.php'); // Weiterleitung, wenn der User kein Admin ist.
    exit;
}

// Abrufen der Reservierungen aus der Datenbank
$reservierungen_query = "SELECT r.reservationsid, r.status, r.anreisedatum, r.abreisedatum, r.gesamtpreis, r.reservierungsdatum, u.vorname, u.nachname, u.mailadresse, z.bezeichnung
                          FROM reservierungen r
                          JOIN users u ON r.mailadresse = u.mailadresse
                          JOIN zimmer z ON r.zimmerid = z.zimmerid";
$reservierungen_result = $mysqli->query($reservierungen_query);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $reservation_id = $_POST['reservation_id'];
    $new_status = $_POST['new_status'];

    // Update der Reservierung
    $update_query = "UPDATE reservierungen SET status = ? WHERE reservationsid = ?";
    $stmt = $mysqli->prepare($update_query);
    $stmt->bind_param('ii', $new_status, $reservation_id);
    $stmt->execute();

    header('Location: verwaltungreservierungen.php'); // Neuladen der Seite nach dem Statusupdate
    exit;
}
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verwaltung der Reservierungen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <h1>Verwaltung der Reservierungen</h1>

    <?php if ($reservierungen_result->num_rows > 0): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Vorname</th>
                    <th>Nachname</th>
                    <th>Email</th>
                    <th>Zimmer</th>
                    <th>Anreisedatum</th>
                    <th>Abreisedatum</th>
                    <th>Reservierungsdatum</th>
                    <th>Gesamtpreis</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $reservierungen_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['reservationsid']); ?></td>
                        <td><?php echo htmlspecialchars($row['vorname']); ?></td>
                        <td><?php echo htmlspecialchars($row['nachname']); ?></td>
                        <td><?php echo htmlspecialchars($row['mailadresse']); ?></td>
                        <td><?php echo htmlspecialchars($row['bezeichnung']); ?></td>
                        <td><?php echo date('d.m.Y', strtotime($row['anreisedatum'])); ?></td>
                        <td><?php echo date('d.m.Y', strtotime($row['abreisedatum'])); ?></td>
                        <td><?php echo date('d.m.Y', strtotime($row['reservierungsdatum'])); ?></td>
                        <td><?php echo htmlspecialchars(number_format($row['gesamtpreis'], 2)); ?> €</td>
                        <td>
                            <?php
                            // Status als Text anzeigen
                            $statusText = "";
                            switch ($row['status']) {
                                case 0: $statusText = "Neu"; break;
                                case 1: $statusText = "Bestätigt"; break;
                                case 2: $statusText = "Storniert"; break;
                            }
                            echo htmlspecialchars($statusText);
                            ?>
                        </td>
                        <td>
                            <form method="post" action="verwaltungreservierungen.php" style="display:inline;">
                                <input type="hidden" name="reservation_id" value="<?php echo htmlspecialchars($row['reservationsid']); ?>">
                                <select name="new_status" class="form-select" required>
                                    <option value="0" <?php if ($row['status'] == 0) echo 'selected'; ?>>Neu</option>
                                    <option value="1" <?php if ($row['status'] == 1) echo 'selected'; ?>>Bestätigt</option>
                                    <option value="2" <?php if ($row['status'] == 2) echo 'selected'; ?>>Storniert</option>
                                </select>
                                <button type="submit" name="update_status" class="btn btn-success btn-sm">Status ändern</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Keine Reservierungen gefunden.</p>
    <?php endif; ?>

</div>

<?php include 'footer.php'; ?>
</body>
</html>
