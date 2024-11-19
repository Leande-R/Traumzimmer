<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS einbinden -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding-top: 100px; /* Abstand für die Navbar */
        }
        .container {
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px; /* Abstand zwischen den Containern */
            background-color: #fff;
        }
        .form-section {
            margin-bottom: 20px;
        }
        .form-section h2 {
            margin-bottom: 20px;
        }
        .form-section form input {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-section form button {
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-section form button:hover {
            background-color: #0056b3;
        }

        footer {
            background-color: #343a40;
            color: #fff;
            padding: 10px 0;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="images/LogoBreit.png" alt="Logo" style="height: 60px;">
            </a>
        </div>
    </nav>

    <!-- Insert an image below the navbar -->
    <div class="container mt-4 text-center">
        <img src="images/Hotel4_3.jpg" alt="Your Image" class="img-fluid" style="max-width: 100%; height: auto;">
    </div>

    <!-- Formulare -->
    <div class="container mt-4">
        <div class="row">
            <!-- Login -->
            <div class="col-md-6 form-section">
                <h2>Login</h2>
                <form action="/login" method="post">
                    <input type="text" name="username" placeholder="Benutzername" required>
                    <input type="password" name="password" placeholder="Passwort" required>
                    <button type="submit">Login</button>
                </form>
            </div>
        </div>

        <!-- Registrierung Hinweis -->
        <div class="mt-3">
            <p>Noch keinen Account? <a href="Registration.php">Hier registrieren</a>.</p>
        </div>
    </div>

    <!-- Footer -->
<?php include 'footer.php'; ?> 

    <!-- Bootstrap JS und Abhängigkeiten -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
