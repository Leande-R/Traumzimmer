<?php
session_start();

// Dummy reservation data (for the sake of this example)
$reservations = [
    'admin' => [
        1 => [
            'zimmer' => 'Doppelzimmer Premium',
            'checkin' => '2024-12-01',
            'checkout' => '2024-12-05',
            'guests' => 2,
            'status' => 'neu',
        ],
        2 => [
            'zimmer' => 'Einzelzimmer Deluxe',
            'checkin' => '2024-12-10',
            'checkout' => '2024-12-12',
            'guests' => 1,
            'status' => 'bestätigt',
        ],
    ],
    'user1' => [
        1 => [
            'zimmer' => 'Doppelzimmer Standard',
            'checkin' => '2024-12-03',
            'checkout' => '2024-12-07',
            'guests' => 2,
            'status' => 'neu',
        ],
    ]
];

// Check if user is logged in
if (!isset($_SESSION['username']) || !isset($reservations[$_SESSION['username']])) {
    echo "Sie müssen sich anmelden, um diese Seite zu sehen.";
    exit;
}

$is_admin = ($_SESSION['username'] === 'admin');  // Check if logged-in user is admin

// Handle the status update (only for admin)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $is_admin) {
    $reservation_id = $_POST['reservation_id'];
    $action = $_POST['action'];

    // Check if the reservation exists for the logged-in user or admin
    if (isset($reservations[$_SESSION['username']][$reservation_id])) {
        if ($action === 'bestätigt') {
            $reservations[$_SESSION['username']][$reservation_id]['status'] = 'bestätigt';
        } elseif ($action === 'storniert') {
            $reservations[$_SESSION['username']][$reservation_id]['status'] = 'storniert';
        }
    }
}

?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meine Reservierungen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .status-new { background-color: #f0ad4e; color: white; }
        .status-confirmed { background-color: #5bc0de; color: white; }
        .status-cancelled { background-color: #d9534f; color: white; }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?> <!-- Include the navbar -->

<div class="container mt-5">
    <h1>Meine Reservierungen</h1>
    <p class="text-muted">Verwalten Sie Ihre Reservierungen:</p>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Zimmer</th>
                <th>Anreisedatum</th>
                <th>Abreisedatum</th>
                <th>Gäste</th>
                <th>Status</th>
                <?php if ($is_admin): ?>
                    <th>Aktion</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservations[$_SESSION['username']] as $reservation_id => $reservation): ?>
                <tr>
                    <td><?= htmlspecialchars($reservation['zimmer']); ?></td>
                    <td><?= htmlspecialchars($reservation['checkin']); ?></td>
                    <td><?= htmlspecialchars($reservation['checkout']); ?></td>
                    <td><?= htmlspecialchars($reservation['guests']); ?></td>
                    <td class="status-<?= strtolower($reservation['status']); ?>">
                        <?= htmlspecialchars(ucfirst($reservation['status'])); ?>
                    </td>
                    <?php if ($is_admin): ?>
                        <td>
                            <?php if ($reservation['status'] === 'neu'): ?>
                                <form method="post" class="d-inline">
                                    <input type="hidden" name="reservation_id" value="<?= $reservation_id; ?>">
                                    <button type="submit" name="action" value="bestätigt" class="btn btn-success btn-sm">Bestätigen</button>
                                    <button type="submit" name="action" value="storniert" class="btn btn-danger btn-sm">Stornieren</button>
                                </form>
                            <?php elseif ($reservation['status'] === 'bestätigt'): ?>
                                <span class="badge bg-info">Bestätigt</span>
                            <?php elseif ($reservation['status'] === 'storniert'): ?>
                                <span class="badge bg-danger">Storniert</span>
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    

<!-- Footer -->
<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
