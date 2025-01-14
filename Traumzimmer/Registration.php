<?php
session_start(); // Start session
require 'dbaccess.php'; // Include database connection settings
$error = ''; 
$success = ''; 

// Initialize the users array in the session if not already set
if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [];
}


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $anrede = $_POST['anrede'];
    $vorname = trim($_POST['vorname']);
    $nachname = trim($_POST['nachname']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

   // Eingaben prüfen
   if ($password !== $confirmPassword) {
    $error = "Die Passwörter stimmen nicht überein.";
} else {
    try {
                // Prüfen, ob die E-Mail-Adresse oder der Benutzername bereits existieren
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE mailadresse = :mailadresse OR benutzername = :benutzername");
        $stmt->execute([':mailadresse' => $mailadresse, ':benutzername' => $benutzername]);
        $exists = $stmt->fetchColumn();

        if ($exists) {
            $error = "E-Mail-Adresse oder Benutzername existiert bereits.";
        } else {
            // Passwort hashen
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Benutzer in die Datenbank einfügen
            $stmt = $pdo->prepare("INSERT INTO users (mailadresse, anrede, vorname, nachname, benutzername, passwort, admin) 
                                   VALUES (:mailadresse, :anrede, :vorname, :nachname, :benutzername, :passwort, :admin)");
            $stmt->execute([
                ':mailadresse' => $email,
                ':anrede' => $anrede,
                ':vorname' => $vorname,
                ':nachname' => $nachname,
                ':benutzername' => $username,
                ':passwort' => $hashedPassword,
                ':admin' => FALSE // Standardwert, kein Admin
            ]);

            $success = "Registrierung erfolgreich! Bitte melden Sie sich an.";
            header("Location: login.php");
            exit;
        }
    } catch (PDOException $e) {
        $error = "Fehler bei der Datenbankverbindung: " . $e->getMessage();
    }
}
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrierung</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<?php include 'navbar.php'; ?> <!-- Include the navbar -->

<body>

<!-- Insert an image below the navbar -->
<div class="container mt-4 text-center">
    <img src="images/Hotel4_3.jpg" alt="Hotel Image" class="img-fluid" style="max-width: 100%; height: auto;">
</div>

<!-- Registration Form -->
<div class="container mt-5">
    <h2 class="mb-4">Registrierungsformular</h2>

    <!-- Display error or success messages -->
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <!-- Registration Form -->
    <form action="registration.php" method="POST">
        <div class="form-group">
            <label for="anrede">Anrede</label>
            <select class="form-control" id="anrede" name="anrede" required>
                <option value="">Wählen Sie...</option>
                <option value="0">Herr</option>
                <option value="1">Frau</option>
                <option value="2">Keine Angabe</option>
            </select>
        </div>
        <div class="form-group">
            <label for="vorname">Vorname</label>
            <input type="text" class="form-control" id="vorname" name="vorname" placeholder="Vorname eingeben" required>
        </div>
        <div class="form-group">
            <label for="nachname">Nachname</label>
            <input type="text" class="form-control" id="nachname" name="nachname" placeholder="Nachname eingeben" required>
        </div>
        <div class="form-group">
            <label for="email">E-Mail-Adresse</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="E-Mail-Adresse eingeben" required>
        </div>
        <div class="form-group">
            <label for="username">Benutzername</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Benutzername eingeben" required>
        </div>
        <div class="form-group">
            <label for="password">Passwort</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Passwort eingeben" required>
        </div>
        <div class="form-group">
            <label for="confirmPassword">Passwort bestätigen</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Passwort bestätigen" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrieren</button>
    </form>
</div>

<!-- Footer -->
<?php include 'footer.php'; ?> 

</body>
</html>