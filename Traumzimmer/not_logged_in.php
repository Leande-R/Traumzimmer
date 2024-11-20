<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login erforderlich</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Add padding to avoid overlap with the navbar */
        .content-wrapper {
            margin-top: 100px; /* Adjust this value if necessary */
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container content-wrapper text-center">
    <h1>Sie sind nicht eingeloggt</h1>
    <p class="lead">Um diese Seite nutzen zu können, müssen Sie sich zuerst einloggen.</p>
    <a href="login.php" class="btn btn-primary">Zum Login</a>
</div>
<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>