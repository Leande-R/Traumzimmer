<?php
session_start();
require 'dbaccess.php';

$error = '';

// Überprüfung der Anmeldedaten
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        try {
            // Benutzer aus der Datenbank basierend auf der E-Mail-Adresse abrufen
            $stmt = $pdo->prepare("SELECT * FROM users WHERE mailadresse = :mailadresse");
            $stmt->execute([':mailadresse' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['passwort'])) {
                // Login erfolgreich: Daten in der Session speichern
                $_SESSION['username'] = $user['benutzername'];
                $_SESSION['vorname'] = $user['vorname'];
                $_SESSION['nachname'] = $user['nachname'];
                $_SESSION['email'] = $user['mailadresse'];
                $_SESSION['loggedin'] = true;

                // Weiterleitung zur Startseite
                header('Location: index.php');
                exit;
            } else {
                $error = 'Ungültige E-Mail-Adresse oder Passwort.';
            }
        } catch (PDOException $e) {
            $error = "Fehler bei der Datenbankverbindung: " . $e->getMessage();
        }
    } else {
        $error = 'Bitte E-Mail-Adresse und Passwort eingeben.';
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
        .img-container {
            text-align: center;
        }
        .img-container img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
     
    </style>
</head>
 <!-- Navbar -->
 <?php include 'navbar.php'; ?>
<body>
   

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
        <form action="login.php" method="POST" class="mx-auto" style="max-width: 400px;">
            <div class="mb-3">
            <label for="email" class="form-label">E-Mail-Adresse:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Passwort:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <!-- Registrierung-Link -->
        <p class="text-center mt-3">Noch nicht registriert? <a href="registration.php">Hier registrieren</a>.</p>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>