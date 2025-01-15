<!DOCTYPE html>
<?php  
require 'dbaccess.php';

include 'navbar.php';

$isAdmin = false;

if (isset($_SESSION['email'])) {
    $email = $mysqli->real_escape_string($_SESSION['email']);
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

    
    // Funktion, um die 3 letzten Newsbeiträge abzurufen
    function displayLatestNews() {
        global $mysqli;  // Zugriff auf die globale mysqli-Verbindung
    
        // SQL-Abfrage, um die letzten 3 Newsbeiträge abzurufen (sortiert nach dem Upload-Datum)
        $sql = "SELECT titel, inhalt, bildpfad, uploaddatum FROM news ORDER BY uploaddatum DESC LIMIT 3";
    
        // Führen Sie die SQL-Abfrage aus
        $result = $mysqli->query($sql);
    
        // Überprüfen, ob Ergebnisse vorhanden sind
        if ($result->num_rows > 0) {
            // Schleife durch die Ergebnisse und gebe sie aus
            while ($row = $result->fetch_assoc()) {
                echo '<h2>' . htmlspecialchars($row['titel']) . '</h2>';
                echo '<p><strong>Veröffentlicht am:</strong> ' . date('d.m.Y H:i', strtotime($row['uploaddatum'])) . '</p>';
                echo '<p>' . nl2br(htmlspecialchars($row['inhalt'])) . '</p>';
                
                // Bild anzeigen, falls vorhanden
                if (!empty($row['bildpfad'])) {
                    echo '<img src="' . htmlspecialchars($row['bildpfad']) . '" alt="Bild" style="max-width: 100%; height: auto;" />';
                }
    
                echo '<hr>';  // Trenner zwischen den Beiträgen
            }
        } else {
            echo 'Es sind keine Newsbeiträge verfügbar.';
        }
    }
    
    // Funktion aufrufen, um die Newsbeiträge anzuzeigen
    displayLatestNews();
    
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
            $author = $mysqli->real_escape_string($_SESSION['email']);
        
            $thumbnailName = basename($_FILES['thumbnail']['name']);
            $thumbnailPath = 'news/thumbnails/' . $thumbnailName;
        
            // Initialisierung von Variablen für die Nachrichten
            $messages = [];
        
            // Zielverzeichnis erstellen, falls nicht vorhanden
            if (!is_dir('news/uploads')) {
                if (!mkdir('news/uploads', 0755, true)) {
                    $messages[] = "Das Verzeichnis 'news/uploads' konnte nicht erstellt werden.";
                }
            }
        
            // Datei hochladen
            if ($_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
                $uploadPath = 'news/uploads/' . $thumbnailName;
                if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $uploadPath)) {
                    $messages[] = "Der Upload war erfolgreich.";
                } else {
                    $messages[] = "Fehler beim Verschieben der Datei.";
                }
            } else {
                $messages[] = "Fehler beim Hochladen der Datei: " . $_FILES['thumbnail']['error'];
            }
        
            // Upload-Datum definieren
            $uploadDate = date('Y-m-d H:i:s');
        
            // SQL-Query vorbereiten
            $stmt = $mysqli->prepare("INSERT INTO news (autor, titel, inhalt, bildpfad, uploaddatum) VALUES (?, ?, ?, ?, ?)");
            if (!$stmt) {
                $messages[] = "Fehler beim Vorbereiten des Statements: " . $mysqli->error;
            }
        
            // Parameter binden
            $stmt->bind_param('sssss', $author, $title, $content, $thumbnailPath, $uploadDate);
        
            // Query ausführen
            if ($stmt->execute()) {
                $messages[] = "Der Newsbeitrag wurde erfolgreich erstellt.";
            } else {
                $messages[] = "Fehler beim Ausführen des Statements: " . $stmt->error;
            }
        
            // Alle Nachrichten anzeigen
            foreach ($messages as $message) {
                echo $message . "<br>"; // Ausgabe der Meldungen untereinander
            }
        
            // Funktion zum Kopieren und Skalieren des Bildes
            function copyImage($sourceFolder, $destinationFolder, $imageName) {
                // Pfad zum Quell- und Zielbild erstellen
                $sourcePath = $sourceFolder . '/' . $imageName;
                $destinationPath = $destinationFolder . '/' . $imageName;
        
                // Überprüfen, ob die Quelldatei existiert
                if (!file_exists($sourcePath)) {
                    echo "Fehler: Die Datei $imageName existiert nicht im Quellordner.";
                    return false;
                }
        
                // Zielordner erstellen, wenn er nicht existiert
                if (!is_dir($destinationFolder)) {
                    if (!mkdir($destinationFolder, 0755, true)) {
                        echo "Fehler: Der Zielordner konnte nicht erstellt werden.";
                        return false;
                    }
                }
        
                // Bildtyp ermitteln
                $imageInfo = getimagesize($sourcePath);
                $imageType = $imageInfo[2];
        
                // Bild je nach Typ laden
                switch ($imageType) {
                    case IMAGETYPE_JPEG:
                        $sourceImage = @imagecreatefromjpeg($sourcePath);
                        break;
                    case IMAGETYPE_PNG:
                        $sourceImage = @imagecreatefrompng($sourcePath);
                        break;
                    case IMAGETYPE_GIF:
                        $sourceImage = @imagecreatefromgif($sourcePath);
                        break;
                    default:
                        echo "Fehler: Unbekannter Bildtyp.";
                        return false;
                }
        
                // Zielgröße setzen (750px Breite, 500px Höhe)
                $newWidth = 750;
                $newHeight = 500;
        
                // Neue Bildgröße berechnen, um das Bild skalieren zu können
                $sourceWidth = imagesx($sourceImage);
                $sourceHeight = imagesy($sourceImage);
        
                // Berechnen des Skalierungsfaktors
                $aspectRatio = $sourceWidth / $sourceHeight;
        
                if ($newWidth / $aspectRatio > $newHeight) {
                    $newWidth = $newHeight * $aspectRatio;
                } else {
                    $newHeight = $newWidth / $aspectRatio;
                }
        
                // Neues leeres Bild erstellen
                $newImage = imagecreatetruecolor($newWidth, $newHeight);
        
                // Bild skalieren
                imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $sourceWidth, $sourceHeight);
        
                // Bild in den Zielordner speichern
                switch ($imageType) {
                    case IMAGETYPE_JPEG:
                        imagejpeg($newImage, $destinationPath, 90); // Qualität 90
                        break;
                    case IMAGETYPE_PNG:
                        imagepng($newImage, $destinationPath);
                        break;
                    case IMAGETYPE_GIF:
                        imagegif($newImage, $destinationPath);
                        break;
                }
        
                // Ressourcen freigeben
                imagedestroy($sourceImage);
                imagedestroy($newImage);
        
                // Die Datei wird erfolgreich kopiert
                echo "Die Datei $imageName wurde erfolgreich zu den Thumbnails hinzugefügt.";
                return true;
            }
        
            // Nachdem das Bild hochgeladen wurde, kopieren und skalieren
            copyImage('news/uploads', 'news/thumbnails', $thumbnailName);
        
            // Statement schließen
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
