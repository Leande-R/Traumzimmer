<?php
session_start(); // Start session
$error = ''; // Initialize error message
$success = ''; // Initialize success message

// Dummy user data array with added attributes
$users = [
    'admin' => [
        'anrede' => 'Herr',
        'vorname' => 'Max',
        'nachname' => 'Mustermann',
        'email' => 'max.mustermann@example.com',
        'password' => password_hash('1234', PASSWORD_DEFAULT) // Example hashed password
    ],
    'user1' => [
        'anrede' => 'Frau',
        'vorname' => 'Eva',
        'nachname' => 'Schmidt',
        'email' => 'eva.schmidt@example.com',
        'password' => password_hash('passwort', PASSWORD_DEFAULT) // Example hashed password
    ]
];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $anrede = $_POST['anrede'];
    $vorname = trim($_POST['vorname']);
    $nachname = trim($_POST['nachname']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validate that the password and confirm password match
    if ($password !== $confirmPassword) {
        $error = "Die Passwörter stimmen nicht überein.";
    } else {
        // Check if the username or email already exists in the session data
        if (array_key_exists($username, $_SESSION['users'])) {
            $error = "Benutzername existiert bereits.";
        } else {
            // Hash the password for storage
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Simulate saving the user by adding them to the session (dummy storage)
            $_SESSION['users'][$username] = $hashedPassword;

            // Success message
            $success = "Registrierung erfolgreich! Bitte melden Sie sich an.";
            header("Location: LogIn.php"); // Redirect to login page
            exit;
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
    <form action="Registration.php" method="POST">
        <div class="form-group">
            <label for="anrede">Anrede</label>
            <select class="form-control" id="anrede" name="anrede" required>
                <option value="">Wählen Sie...</option>
                <option value="Herr">Herr</option>
                <option value="Frau">Frau</option>
                <option value="Keine Angabe">Keine Angabe</option>
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