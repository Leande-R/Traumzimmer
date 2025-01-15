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

// Abrufen aller Benutzer aus der Datenbank
$users_query = "SELECT mailadresse, anrede, vorname, nachname, benutzername, status FROM users";
$users_result = $mysqli->query($users_query);

// Wenn das Formular zur Statusänderung gesendet wurde
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $user_email = $_POST['user_email'];
    $new_status = $_POST['new_status'];

    // Status in der Datenbank aktualisieren
    $update_status_query = "UPDATE users SET status = ? WHERE mailadresse = ?";
    $stmt = $mysqli->prepare($update_status_query);
    $stmt->bind_param('is', $new_status, $user_email);
    $stmt->execute();

    // Neuladen der Seite
    header('Location: verwaltunguser.php');
    exit;
}
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verwaltung der Benutzer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <h1>Verwaltung der Benutzer</h1>

    <?php if ($users_result->num_rows > 0): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Anrede</th>
                    <th>Vorname</th>
                    <th>Nachname</th>
                    <th>Benutzername</th>
                    <th>Status</th>
                    <th>Aktion</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $users_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['mailadresse']); ?></td>
                        <td><?php echo htmlspecialchars($row['anrede'] == 1 ? "Herr" : "Frau"); ?></td>
                        <td><?php echo htmlspecialchars($row['vorname']); ?></td>
                        <td><?php echo htmlspecialchars($row['nachname']); ?></td>
                        <td><?php echo htmlspecialchars($row['benutzername']); ?></td>
                        <td>
                            <?php echo $row['status'] == 1 ? 'Aktiv' : 'Deaktiviert'; ?>
                        </td>
                        <td>
                            <form method="post" action="verwaltunguser.php" style="display:inline;">
                                <input type="hidden" name="user_email" value="<?php echo htmlspecialchars($row['mailadresse']); ?>">
                                <select name="new_status" class="form-select" required>
                                    <option value="1" <?php if ($row['status'] == 1) echo 'selected'; ?>>Aktiv</option>
                                    <option value="0" <?php if ($row['status'] == 0) echo 'selected'; ?>>Deaktiviert</option>
                                </select>
                                <button type="submit" name="update_status" class="btn btn-primary btn-sm">Ändern</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Keine Benutzer gefunden.</p>
    <?php endif; ?>

</div>

<?php include 'footer.php'; ?>
</body>
</html>
