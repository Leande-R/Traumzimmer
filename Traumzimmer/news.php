<!DOCTYPE html>
<?php include 'navbar.php'; 
require 'dbaccess.php';

session_start(); // Session starten

// Überprüfen, ob der Benutzer eingeloggt ist und ob er Admin ist
$isAdmin = false;
if (isset($_SESSION['user_email'])) {
    $email = $mysqli->real_escape_string($_SESSION['user_email']);
    $query = "SELECT admin FROM users WHERE mailadresse = ?";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['admin'] == 1) {
                $isAdmin = true;
            }
        }
        $stmt->close();
    } else {
        die("Fehler beim Vorbereiten der Abfrage: " . $mysqli->error);
    }
}

?>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News-Beiträge</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .card-img-top {
            width: 100%; /* Bild passt sich der Breite der Karte an */
            height: auto; /* Dynamische Höhe */
            object-fit: cover; /* Beibehaltung der Proportionen */
        }
        .card {
            margin-bottom: 20px;
        }
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }
        
        
        }
    </style>
</head>
<body>
<div class="container py-5">

    <h1 class="mb-4 text-center" style="padding-top: 80px;">News-Beiträge</h1>
    

    <?php
    // Datenbankzugriff
    require 'dbaccess.php'; // Datenbankverbindung wird hier eingebunden

    // Alle News-Beiträge aus der Datenbank abrufen
    

    ?>
    <?php
    if ($isAdmin): ?>
        <h2 style="text-align: center; padding-bottom: 50px; padding-top: 50px;">Newsbeitrag erstellen</h2>
            <div style="display: flex; justify-content: center; align-items: center; height: auto; margin-top: 20px;">
            <form action="news.php" method="post" enctype="multipart/form-data" style="width: 100%; max-width: 400px; padding: 20px; border: 1px solid #ccc; border-radius: 10px; background-color: #f9f9f9;">
            <label for="title" style="font-size: 1.2em;">Titel:</label>
            <input type="text" id="title" name="title" required style="width: 100%; padding: 10px; font-size: 1em; margin-bottom: 15px;"><br>

            <label for="content" style="font-size: 1.2em;">Beitrag:</label>
            <textarea id="content" name="content" required style="width: 100%; padding: 10px; font-size: 1em; height: 150px; margin-bottom: 15px;"></textarea><br>

            <label for="thumbnail" style="font-size: 1.2em;">Thumbnail</label>
            <input type="file" id="thumbnail" name="thumbnail" accept="image/*" required style="width: 100%; padding: 10px; font-size: 1em; margin-bottom: 15px;"><br>

            <button type="submit" style="padding: 10px 20px; font-size: 1.2em; cursor: pointer; background-color: #4CAF50; color: white; border: none; border-radius: 5px;">Beitrag erstellen</button>
        </form>
    </div>


<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $mysqli->real_escape_string($_POST['title']);
        $content = $mysqli->real_escape_string($_POST['content']);
        $author = $mysqli->real_escape_string($_SESSION['user_email']);

        $thumbnailName = basename($_FILES['thumbnail']['name']);
        $thumbnailPath = 'Traumzimmer/news/thumbnails/' . $thumbnailName;

        if (!is_dir('Traumzimmer/news/thumbnails')) {
            if (!mkdir('Traumzimmer/news/thumbnails', 0755, true)) {
                die("Das Verzeichnis 'Traumzimmer/news/thumbnails' konnte nicht erstellt werden.");
            }
        }

        if ($_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
            if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumbnailPath)) {
                echo "Das Thumbnail wurde erfolgreich hochgeladen.";
            } else {
                die("Fehler beim Verschieben der Datei.");
            }
        } else {
            die("Fehler beim Hochladen der Datei: " . $_FILES['thumbnail']['error']);
        }

        $stmt = $mysqli->prepare("INSERT INTO news (autor, titel, inhalt, bildpfad, uploaddatum) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            die("Fehler beim Vorbereiten des Statements: " . $mysqli->error);
        }

        $uploadDate = date('Y-m-d H:i:s');
        $stmt->bind_param('sssss', $author, $title, $content, $thumbnailPath, $uploadDate);

        if ($stmt->execute()) {
            echo "Der Newsbeitrag wurde erfolgreich erstellt.";
        } else {
            die("Fehler beim Ausführen des Statements: " . $stmt->error);
        }

        $stmt->close();
    }
    ?>
<?php endif; ?>

</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php include 'footer.php'; ?>
</html>
