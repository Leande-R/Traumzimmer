<?php
session_start();

// Dummy reservation data
$reservations = [
    'user1' => [
        [
            'zimmer' => 'Einzelzimmer Premium',
            'guests' => 1,
            'checkin' => '2024-12-10',
            'checkout' => '2024-12-12',
            'breakfast' => 'Ja',
            'parking' => 'Nein',
            'pets' => 'Ja'
        ],
        [
            'zimmer' => 'Doppelzimmer Deluxe',
            'guests' => 2,
            'checkin' => '2024-12-20',
            'checkout' => '2024-12-22',
            'breakfast' => 'Nein',
            'parking' => 'Ja',
            'pets' => 'Nein'
        ]
    ],
    'admin' => [
        [
            'zimmer' => 'Doppelzimmer Standard',
            'guests' => 1,
            'checkin' => '2024-11-25',
            'checkout' => '2024-11-27',
            'breakfast' => 'Ja',
            'parking' => 'Ja',
            'pets' => 'Nein'
        ]
    ]
];

// Check if user is logged in
if (!isset($_SESSION['username']) || !isset($reservations[$_SESSION['username']])) {
    echo "You need to log in first.";
    exit;
}

// Fetch logged-in user's reservations
$username = $_SESSION['username'];
$user_reservations = $reservations[$username];
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meine Reservierungen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?> <!-- Include the navbar -->

<div class="container mt-5">
    <h1>Meine Reservierungen</h1>

    <?php if (empty($user_reservations)): ?>
        <p>Sie haben keine Reservierungen.</p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Zimmer</th>
                    <th>Gäste</th>
                    <th>Anreisedatum</th>
                    <th>Abreisedatum</th>
                    <th>Frühstück</th>
                    <th>Parkplatz</th>
                    <th>Haustiere</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($user_reservations as $reservation): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($reservation['zimmer']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['guests']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['checkin']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['checkout']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['breakfast']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['parking']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['pets']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>


<div class="text-center mt-4">
        <img src="images/Hotel2_3.jpg" alt="Hotel Image" class="img-fluid rounded">
    </div>
</div>

<!-- Footer -->
<?php include 'footer.php'; ?>
</body>
</html>
