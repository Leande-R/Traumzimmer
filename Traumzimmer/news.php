<?php
// Set error reporting for debugging during development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include Navbar and Footer
include 'navbar.php';
include 'footer.php';

// Verzeichnisse für hochgeladene Bilder und Thumbnails
define('UPLOAD_DIR', __DIR__ . '/news/uploads/');
define('THUMBNAIL_DIR', __DIR__ . '/news/thumbnails/');
define('THUMBNAIL_WIDTH', 200); // Breite des Thumbnails in Pixeln

// Statische News-Beiträge (Hotel-Bezug)
$newsPosts = [
    [
        'title' => 'Neues Wellness-Angebot',
        'content' => 'Unser Hotel bietet ab sofort ein erweitertes Wellness-Angebot mit Sauna, Dampfbad und einem neuen Infinity-Pool. Entspannen Sie sich in luxuriöser Umgebung!',
        'image' => 'default1.jpg'
    ],
    [
        'title' => 'Kulinarische Highlights im Restaurant',
        'content' => 'Freuen Sie sich auf ein exklusives 5-Gänge-Menü von unserem neuen Küchenchef. Erleben Sie Gourmet-Genuss in unserem neu renovierten Hotelrestaurant.',
        'image' => 'default2.jpg'
    ],
];

// Funktion für das Erstellen eines Thumbnails
function createThumbnail($filePath, $destinationPath, $thumbWidth) {
    $imageInfo = getimagesize($filePath);
    if (!$imageInfo) return false;

    list($width, $height) = $imageInfo;
    $mime = $imageInfo['mime'];

    // Originalbild je nach MIME-Typ laden
    switch ($mime) {
        case 'image/jpeg':
            $srcImage = imagecreatefromjpeg($filePath);
            break;
        case 'image/png':
            $srcImage = imagecreatefrompng($filePath);
            break;
        case 'image/gif':
            $srcImage = imagecreatefromgif($filePath);
            break;
        default:
            return false;
    }

    // Neue Thumbnail-Höhe berechnen, um die Proportionen beizubehalten
    $thumbHeight = intval($height * $thumbWidth / $width);

    // Neues leeres Bild erstellen und skalieren
    $thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
    imagecopyresampled($thumbImage, $srcImage, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);

    // Thumbnail speichern
    imagejpeg($thumbImage, $destinationPath, 80);

    // Speicher freigeben
    imagedestroy($srcImage);
    imagedestroy($thumbImage);

    return true;
}

// Bild-Upload verarbeiten
if ($_SESSION['username'] === 'admin' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $uploadFile = $_FILES['image'] ?? null;

    if ($uploadFile && !empty($title) && !empty($content)) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($uploadFile['type'], $allowedTypes)) {
            $fileName = basename($uploadFile['name']);
            $uploadPath = UPLOAD_DIR . $fileName;
            $thumbPath = THUMBNAIL_DIR . $fileName;

            // Verzeichnisse erstellen, falls nicht vorhanden
            if (!is_dir(UPLOAD_DIR)) mkdir(UPLOAD_DIR, 0755, true);
            if (!is_dir(THUMBNAIL_DIR)) mkdir(THUMBNAIL_DIR, 0755, true);

            // Bild hochladen
            if (move_uploaded_file($uploadFile['tmp_name'], $uploadPath)) {
                // Thumbnail erstellen
                if (createThumbnail($uploadPath, $thumbPath, THUMBNAIL_WIDTH)) {
                    echo "News-Beitrag erfolgreich hochgeladen und Thumbnail erstellt.";
                } else {
                    echo "Thumbnail konnte nicht erstellt werden.";
                }
            } else {
                echo "Fehler beim Hochladen des Bildes.";
            }
        } else {
            echo "Ungültiger Dateityp. Nur JPEG, PNG und GIF sind erlaubt.";
        }
    } else {
        echo "Bitte füllen Sie alle Felder aus und laden Sie ein Bild hoch.";
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News-Beiträge</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h1 class="mb-4 text-center">News-Beiträge</h1>
    <div class="row">
        <?php foreach ($newsPosts as $post): ?>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <?php if (!empty($post['image'])): ?>
                        <img src="news/thumbnails/<?= htmlspecialchars($post['image']) ?>" class="card-img-top" alt="News Bild">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($post['title']) ?></h5>
                        <p class="card-text"><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if ($_SESSION['username'] === 'admin'): ?>
        <div class="mt-5">
            <h2>Neuen News Beitrag hochladen</h2>
            <form action="news.php" method="POST" enctype="multipart/form-data" class="mt-3">
                <div class="mb-3">
                    <label for="title" class="form-label">Überschrift</label>
                    <input type="text" id="title" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Text</label>
                    <textarea id="content" name="content" rows="4" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Bild</label>
                    <input type="file" id="image" name="image" class="form-control" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary">Beitrag hochladen</button>
            </form>
        </div>
    <?php endif; ?>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
