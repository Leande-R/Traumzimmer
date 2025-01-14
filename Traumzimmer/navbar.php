<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'dbaccess.php';

$error = ''; // Fehlermeldung


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']); // 
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        try {
            // Benutzerdaten anhand der E-Mail aus der Datenbank holen
            $stmt = $pdo->prepare("SELECT * FROM users WHERE mailadresse = :email");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Überprüfen, ob der Benutzer existiert und das Passwort korrekt ist
            if ($user && password_verify($password, $user['passwort'])) {
                // Benutzer erfolgreich eingeloggt, Session starten und Benutzerinfo speichern
                $_SESSION['username'] = $user['benutzername'];
                $_SESSION['vorname'] = $user['vorname'];
                $_SESSION['nachname'] = $user['nachname'];
                $_SESSION['email'] = $user['mailadresse'];
                $_SESSION['loggedin'] = true;

               
                header('Location: index.php');
                exit; 
            } else {
                $error = 'Ungültige E-Mail-Adresse oder Passwort.';
            }
        } catch (PDOException $e) {
            $error = 'Fehler bei der Datenbankverbindung: ' . $e->getMessage();
        }
    } else {
        $error = 'Bitte geben Sie sowohl E-Mail-Adresse als auch Passwort ein.';
    }
}


?>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="index.php">
            <img src="images/LogoBreit.png" alt="Logo" style="height: 60px;">
        </a>

        <!-- Navbar-Toggler für mobile Ansicht -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- News-Button -->
                <li class="nav-item">
                    <a class="nav-link" href="News.php">News</a>


                <?php if (isset($_SESSION['username'])): ?>
                    <!-- Benutzername anzeigen -->
                    <li class="nav-item">
                        <a class="nav-link" href="User.php">
                        Willkommen, <?= htmlspecialchars($_SESSION['username']); ?>
                        </a>
                    </li>
                    <!-- Logout -->
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <!-- Login-Button für nicht eingeloggte Benutzer -->
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
                            Login
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<style>
    body {
        padding-top: 80px; /* Platz schaffen, damit Inhalte nicht hinter der Navbar verschwinden */
    }
</style>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Fehleranzeige -->
                <?php if ($error): ?>
                    <div class="alert alert-danger text-center" role="alert">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                
                <!-- Login-Formular -->
                <form action="login.php" method="POST">
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
                <p class="text-center mt-3">Noch keinen Account? <a href="registration.php">Hier registrieren</a>.</p>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS und Abhängigkeiten -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
