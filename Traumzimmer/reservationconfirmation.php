<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: not_logged_in.php');
    exit;
}

// Check if reservation data exists
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: reservation.php');
    exit;
}

// Retrieve reservation details from POST data
$guests = $_POST['guests'] ?? '';
$checkin = $_POST['checkin'] ?? '';
$checkout = $_POST['checkout'] ?? '';
$zimmer = $_POST['zimmer'] ?? '';
$breakfast = $_POST['breakfast'] ?? 'no';
$parking = $_POST['parking'] ?? 'no';
$pets = $_POST['pets'] ?? 'no';
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reservierungsbestätigung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        body {
            background: url('images/Hotel4_3.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }
        .content-wrapper {
            flex: 1;
            background-color: rgba(0, 0, 0, 0.7);
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
    <h1 class="text-center">Vielen Dank für Ihre Reservierung!</h1>
    <p class="mt-4">Hier sind Ihre Reservierungsdetails:</p>
    <ul class="list-group">
        <li class="list-group-item bg-dark text-white">Anzahl der Gäste: <?= htmlspecialchars($guests) ?></li>
        <li class="list-group-item bg-dark text-white">Anreisedatum: <?= htmlspecialchars($checkin) ?></li>
        <li class="list-group-item bg-dark text-white">Abreisedatum: <?= htmlspecialchars($checkout) ?></li>
        <li class="list-group-item bg-dark text-white">Zimmer: <?= htmlspecialchars($zimmer) ?></li>
        <li class="list-group-item bg-dark text-white">Frühstück: <?= $breakfast === 'yes' ? 'Ja' : 'Nein' ?></li>
        <li class="list-group-item bg-dark text-white">Parkplatz: <?= $parking === 'yes' ? 'Ja' : 'Nein' ?></li>
        <li class="list-group-item bg-dark text-white">Mit Haustier: <?= $pets === 'yes' ? 'Ja' : 'Nein' ?></li>
    </ul>
    <div class="mt-4 text-center">
        <a href="reservation.php" class="btn btn-primary">Weitere Reservierung vornehmen</a>
    </div>
</div>

<!-- Footer -->
<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
