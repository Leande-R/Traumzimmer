<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
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
                            <?= htmlspecialchars($_SESSION['username']); ?>
                        </a>
                    </li>
                    <!-- Logout -->
                    <li class="nav-item">
                        <a class="nav-link" href="LogOut.php">Logout</a>
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
                <form action="LogIn.php" method="POST">
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
                <p class="text-center mt-3">Noch keinen Account? <a href="Registration.php">Hier registrieren</a>.</p>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS und Abhängigkeiten -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
