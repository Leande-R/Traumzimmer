<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>


<body>
    <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.html">
            <img src="images/LogoBreit.png" alt="Logo" style="height: 60px;">
        </a>
    </div>
</nav>

<!-- Insert an image below the navbar -->
<div class="container mt-4 text-center">
    <img src="images/Hotel4_3.jpg" alt="Your Image" class="img-fluid" style="max-width: 100%; height: auto;">
</div>
    
    <!-- Header from index.html -->
    <!-- Replace this comment with the actual header content from your index.html file -->
    
    <div class="container mt-5">
        <h2 class="mb-4">Registration Form</h2>
        <form>
            <div class="form-group">
                <label for="anrede">Anrede</label>
                <select class="form-control" id="anrede" required>
                    <option value="">Select</option>
                    <option value="Herr">Herr</option>
                    <option value="Frau">Frau</option>
                </select>
            </div>
            <div class="form-group">
                <label for="vorname">Vorname</label>
                <input type="text" class="form-control" id="vorname" placeholder="Enter Vorname" required>
            </div>
            <div class="form-group">
                <label for="nachname">Nachname</label>
                <input type="text" class="form-control" id="nachname" placeholder="Enter Nachname" required>
            </div>
            <div class="form-group">
                <label for="email">E-Mail-Adresse</label>
                <input type="email" class="form-control" id="email" placeholder="Enter E-Mail-Adresse" required>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Enter Username" required>
            </div>
            <div class="form-group">
                <label for="password">Passwort</label>
                <input type="password" class="form-control" id="password" placeholder="Enter Passwort" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Passwort bestätigen</label>
                <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Passwort" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>

   <!-- Footer -->

<?php include 'footer.php'; ?> 

  
</body>
</html>