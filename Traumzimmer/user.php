<?php
session_start();
require 'dbaccess.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: not_logged_in.php');
    exit;
}

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

// Fetch logged-in user's data using mailadresse (Primary Key)
$email = $_SESSION['email']; // Achte darauf, dass die E-Mail in der Session gespeichert wird

$sql = "SELECT * FROM users WHERE mailadresse = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Benutzer nicht gefunden.";
    exit;
}

$message = '';
// Handle form submission for profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $vorname = trim($_POST['vorname']);
        $nachname = trim($_POST['nachname']);
        $email = trim($_POST['email']);
        $current_password = $_POST['current_password'];
        $new_password = $_POST['password'];
        $new_password_confirmation = $_POST['password_confirmation']; // Neues Passwort bestätigen

        // Check if new passwords match
        if ($new_password !== $new_password_confirmation) {
            $message = "Die beiden eingegebenen Passwörter stimmen nicht überein.";
        } else {

        // Verify current password
        if (password_verify($current_password, $user['passwort'])) {
            // Update user details (using mailadresse as unique identifier)
            $sql = "UPDATE users SET vorname = ?, nachname = ?, mailadresse = ?, status = ? WHERE mailadresse = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param('sssds', $vorname, $nachname, $email, $status, $email);
            $stmt->execute();

            // Update password if provided
            if (!empty($new_password)) {
                $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET passwort = ? WHERE mailadresse = ?";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param('ss', $new_password_hash, $email);
                $stmt->execute();
                $message = "Benutzerdaten und Passwort erfolgreich aktualisiert!";
            } else {
                $message = "Benutzerdaten erfolgreich aktualisiert!";
            }
        } else {
            $message = "Das eingegebene Passwort ist inkorrekt.";
    }
}

}
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Benutzerdaten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        input[readonly] {
            background-color: #e9ecef !important; /* Grau hinterlegen */
            cursor: not-allowed; /* Zeigt an, dass das Feld nicht bearbeitet werden kann */
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <h1>Benutzerdaten</h1>
    <p class="text-muted">Hinweis: Um Ihre Benutzerdaten zu ändern, geben Sie bitte Ihr jetziges Passwort an!</p>

    <?php if (!empty($message)): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="post" class="mt-4">
        <!-- Mailadresse (readonly) -->
        <div class="mb-3">
            <label for="email" class="form-label">E-Mail:</label>
            <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['mailadresse']); ?>" readonly placeholder="Ihre E-Mail-Adresse">
        </div>
        <!-- Benutzername (veränderbar) -->
        <div class="mb-3">
            <label for="username" class="form-label">Benutzername:</label>
            <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($user['benutzername']); ?>" required placeholder="Benutzername ändern">
        </div>
        <!-- Vorname -->
        <div class="mb-3">
            <label for="vorname" class="form-label">Vorname:</label>
            <input type="text" id="vorname" name="vorname" class="form-control" value="<?php echo htmlspecialchars($user['vorname']); ?>" required placeholder="Ihr Vorname">
        </div>
        <!-- Nachname -->
        <div class="mb-3">
            <label for="nachname" class="form-label">Nachname:</label>
            <input type="text" id="nachname" name="nachname" class="form-control" value="<?php echo htmlspecialchars($user['nachname']); ?>" required placeholder="Ihr Nachname">
        </div>
        <!-- Aktuelles Passwort -->
        <div class="mb-3">
            <label for="current_password" class="form-label">Aktuelles Passwort:</label>
            <input type="password" id="current_password" name="current_password" class="form-control" required placeholder="Ihr aktuelles Passwort">
        </div>
        <!-- Neues Passwort -->
        <div class="mb-3">
            <label for="password" class="form-label">Neues Passwort (optional):</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Neues Passwort eingeben">
        </div>
        <!-- Bestätigung des neuen Passworts -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Neues Passwort bestätigen:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Bestätigen Sie Ihr neues Passwort">
        </div>

        <button type="submit" class="btn btn-primary">Aktualisieren</button>
    </form>

    <div class="mt-4">
        <h3>Meine Reservierungen</h3>
        <a href="myreservations.php" class="btn btn-secondary">Zu meinen Reservierungen</a>
    </div>

    <?php if ($isAdmin): ?>
        <h1>Admin Bereich</h1>
        <div class="mt-4">
            <h3>Reservierungen-Verwaltung</h3>
            <a href="verwaltungreservierungen.php" class="btn btn-secondary">Reservierungen-Verwaltung</a>
        </div>
        <div class="mt-4">
            <h3>User-Verwaltung</h3>
            <a href="verwaltunguser.php" class="btn btn-secondary">User-Verwaltung</a>
        </div>
    <?php endif; ?>
</div>

<!-- Footer -->
<?php include 'footer.php'; ?>
</body>
</html>
