<?php
session_start();
// Dummy user data
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
    // php error will be found in next sprint :( 
// Dummy room data
$rooms = [
    ['id' => 1, 'name' => 'Doppel Zimmer Premium', 'description' => 'Höchster Wohnkomfort.'],
    ['id' => 2, 'name' => 'Doppel Zimmer Deluxe', 'description' => 'Luxuriöse Einrichtung.'],
    ['id' => 3, 'name' => 'Einzelzimmer 1', 'description' => 'Gemütliches Einzelzimmer.']
];

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: not_logged_in.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $guests = $_POST['guests'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];

    echo "<h2>Vielen Dank für Ihre Reservierung!</h2>";
    echo "<p>Anzahl der Gäste: $guests</p>";
    echo "<p>Anreisedatum: $checkin</p>";
    echo "<p>Abreisedatum: $checkout</p>";
    exit;
}
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reservierung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%; /* Ensure the page takes up the full height */
            margin: 0;   /* Remove default margins */
            display: flex;
            flex-direction: column; /* Arrange elements vertically */
        }
        body {
            background: url('images/Hotel4_3.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }
        .content-wrapper {
            flex: 1; /* Take up remaining space */
            background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent overlay for readability */
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        footer {
            background-color: #343a40;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container content-wrapper">
    <h1 class="text-center">Reservierung</h1>
    <form method="post" action="reservation.php">
        <div class="mb-3">
            <label for="guests" class="form-label">Anzahl der Gäste:</label>
            <input type="number" id="guests" name="guests" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="checkin" class="form-label">Anreisedatum:</label>
            <input type="date" id="checkin" name="checkin" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="checkout" class="form-label">Abreisedatum:</label>
            <input type="date" id="checkout" name="checkout" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Reservieren</button>
    </form>
</div>

<!-- Footer -->
<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>