<?php
session_start();
require 'dbaccess.php';

// Check if user is logged in
if (!isset($_SESSION['username']) || !isset($users[$_SESSION['username']])) {
    echo "You need to log in first.";
    exit;
}

// Fetch logged-in user's data
$username = $_SESSION['username'];
$user = $users[$username];

$message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vorname = trim($_POST['vorname']);
    $nachname = trim($_POST['nachname']);
    $email = trim($_POST['email']);
    $current_password = $_POST['current_password'];
    $new_password = $_POST['password'];

    // Verify current password
    if (password_verify($current_password, $user['password'])) {
        // Update user details
        $user['vorname'] = $vorname;
        $user['nachname'] = $nachname;
        $user['email'] = $email;

        // Update password if provided
        if (!empty($new_password)) {
            $user['password'] = password_hash($new_password, PASSWORD_DEFAULT);
            $message = "Benutzerdaten und Passwort erfolgreich angepasst!";
        } else {
            $message = "Benutzerdaten erfolgreich angepasst!";
        }
    } else {
        $message = "Passwort inkorrekt.";
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
            background-color: #e9ecef;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?> <!-- Include the navbar -->

<div class="container mt-5">
    <h1>Benutzerdaten</h1>
    <p class="text-muted">Hinweis: Um Ihre Benutzerdaten zu ändern, geben Sie bitte Ihr jetziges Passwort an!</p>

    <?php if (!empty($message)): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="post" class="mt-4">
        <div class="mb-3">
            <label for="username" class="form-label">Benutzername:</label>
            <input type="text" id="username" class="form-control" value="<?php echo htmlspecialchars($username); ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="vorname" class="form-label">Vorname:</label>
            <input type="text" id="vorname" name="vorname" class="form-control" value="<?php echo htmlspecialchars($user['vorname']); ?>" required placeholder="Ihr Vorname">
        </div>
        <div class="mb-3">
            <label for="nachname" class="form-label">Nachname:</label>
            <input type="text" id="nachname" name="nachname" class="form-control" value="<?php echo htmlspecialchars($user['nachname']); ?>" required placeholder="Ihr Nachname">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-Mail:</label>
            <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required placeholder="Ihre E-Mail-Adresse">
        </div>
        <div class="mb-3">
            <label for="current_password" class="form-label">Aktuelles Passwort:</label>
            <input type="password" id="current_password" name="current_password" class="form-control" required placeholder="Ihr aktuelles Passwort">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Neues Passwort (optional):</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Neues Passwort eingeben">
        </div>
        <button type="submit" class="btn btn-primary">Aktualisieren</button>
    </form>

    <!-- New segment: Meine Reservierungen -->
    <div class="mt-4">
        <h3>Meine Reservierungen</h3>
        <p>Sehen Sie sich Ihre vergangenen und zukünftigen Reservierungen an:</p>
        <a href="myreservations.php" class="btn btn-link">Zu meinen Reservierungen</a>
    </div>
</div>

<!-- Footer -->
<?php include 'footer.php'; ?>
</body>
</html>
