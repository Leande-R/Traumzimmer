<?php
session_start();

// Beispiel-Benutzer mit Passwort und weiteren Attributen (normalerweise aus einer Datenbank)
$users = [
    'admin' => [
        'password' => password_hash('1234', PASSWORD_DEFAULT),
        'vorname' => 'Max',
        'nachname' => 'Mustermann',
        'email' => 'max@mustermann.de'
    ],
    'user1' => [
        'password' => password_hash('passwort', PASSWORD_DEFAULT),
        'vorname' => 'Eva',
        'nachname' => 'Schmidt',
        'email' => 'eva@schmidt.de'
    ]
];

$error = '';

// Überprüfung der Anmeldedaten
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (isset($users[$username]) && password_verify($password, $users[$username]['password'])) {
        // Login erfolgreich
        $_SESSION['username'] = $username;
        $_SESSION['vorname'] = $users[$username]['vorname'];
        $_SESSION['nachname'] = $users[$username]['nachname'];
        $_SESSION['email'] = $users[$username]['email'];
        header('Location: index.php'); // Weiterleitung zur Startseite
        exit;
    } else {
        $error = 'Ungültiger Benutzername oder Passwort.';
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding-top: 100px; /* Platz für die Navbar */
            background-color: #f8f9fa;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .img-container {
            text-align: center;
        }
        .img-container img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
        footer {
            background-color: #343a40;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="images/LogoBreit.png" alt="Logo" style="height: 60px;">
            </a>
        </div>
    </nav>

    <!-- Bild unter der Navbar -->
    <div class="img-container container">
        <img src="images/Hotel4_3.jpg" alt="Hotel Image">
    </div>

    <!-- Login Formular -->
    <div class="container mt-4">
        <h2 class="text-center">Login</h2>

        <!-- Fehleranzeige -->
        <?php if ($error): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <!-- Login-Formular -->
        <form action="LogIn.php" method="POST" class="mx-auto" style="max-width: 400px;">
            <div class="mb-3">
                <label for="username" class="form-label">Benutzername:</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Passwort:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <!-- Registrierung-Link -->
        <p class="text-center mt-3">Noch nicht registriert? <a href="Registration.php">Hier registrieren</a>.</p>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>