<?php
session_start();
include 'dbaccess.php';  

$checkin = isset($_GET['checkin']) ? htmlspecialchars($_GET['checkin']) : 'nicht angegeben';
$checkout = isset($_GET['checkout']) ? htmlspecialchars($_GET['checkout']) : 'nicht angegeben';
$guests = isset($_GET['guests']) ? intval($_GET['guests']) : 1;

setlocale(LC_TIME, 'de_DE.UTF-8', 'de_DE', 'deu_deu');

// Datumsformat anpassen
$checkinFormatted = ($checkin !== 'nicht angegeben') ? strftime('%A - %d.%m.%Y', strtotime($checkin)) : 'nicht angegeben';
$checkoutFormatted = ($checkout !== 'nicht angegeben') ? strftime('%A - %d.%m.%Y', strtotime($checkout)) : 'nicht angegeben';

// DB-Abfrage, um die verfügbaren Zimmer zu finden
$sql = "
    SELECT zimmer.zimmerid, zimmer.bezeichnung, zimmer.fassungsvermoegen, zimmer.preispronacht
    FROM zimmer
    LEFT JOIN reservierungen ON zimmer.zimmerid = reservierungen.zimmerid
    AND (
        (reservierungen.anreisedatum BETWEEN ? AND ?) 
        OR (reservierungen.abreisedatum BETWEEN ? AND ?)
        OR (reservierungen.anreisedatum <= ? AND reservierungen.abreisedatum >= ?)
    )
    WHERE zimmer.zimmerid IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12)
    AND reservierungen.zimmerid IS NULL;
";

$stmt = $mysqli->prepare($sql);
if ($stmt === false) {
    die('Fehler bei der SQL-Anfrage: ' . $mysqli->error);
}

// Parameters an binden
$stmt->bind_param('ssssss', $checkin, $checkout, $checkin, $checkout, $checkin, $checkout);

// Abfrage ausführen
$stmt->execute();

// Ergebnis abholen
$result = $stmt->get_result();

$freieZimmer = [];
while ($row = $result->fetch_assoc()) {
    $freieZimmer[] = $row;
}

// Zimmer-IDs extrahieren
$freieZimmerIds = array_column($freieZimmer, 'zimmerid');

// Verbindung schließen
$stmt->close();
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Traumzimmer - Ein Ort der Ruhe und Entspannung, an dem Träume zur Wirklichkeit werden</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>

<body>

<?php include 'navbar.php'; ?>

<header class="header">
    <div class="container text-white text-center py-5">
        <h1>Willkommen bei Traumzimmer</h1>
        <p class="lead">Finden Sie Ihr perfektes Zimmer, um den Alltag hinter sich zu lassen!</p>
    </div>
</header>

<section class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
        

            <!-- Titel -->
            <h1 class="mb-4 text-center" style="color: black; font-weight: normal; font-size: 2.5rem; text-shadow: none;">
                Verfügbare Zimmer für den Zeitraum:<br>
                <span style="font-weight: normal;"><?php echo $checkinFormatted; ?></span><br>
                bis<br>
                <span style="font-weight: normal;"><?php echo $checkoutFormatted; ?></span>
            </h1>
        </div>
    </div>
</section>

<!-- Zimmer Carousels und Beschreibungen untereinander -->
<div class="container my-5">
    <div class="row">
        <!-- Doppelzimmer Premium -->
        <div class="col-md-12 mb-4 d-flex align-items-center">
            <div class="carousel-container" style="flex: 1;">
                <div id="carouselExampleIndicators1" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="images/Hotel1_5.jpg" alt="Slide 1">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="images/Hotel2_4.jpg" alt="Slide 2">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators1" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators1" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </div>
            </div>
            <div class="card-body" style="flex: 1; padding-left: 20px;">
                <h5 class="card-title">Doppelzimmer Premium</h5>
                <p class="card-text">Erleben Sie höchsten Wohnkomfort in unserem Doppelzimmer Premium, das stilvolle Akzente und moderne Annehmlichkeiten für einen unvergesslichen Aufenthalt bietet.<br>(300€ pro Nacht)</p>
                <?php if (in_array(1, $freieZimmerIds) || in_array(2, $freieZimmerIds)): ?>
                        <a href="reservation.php?checkin=<?php echo $checkin; ?>&checkout=<?php echo $checkout; ?>&guests=<?php echo $guests; ?>&zimmer=Doppelzimmer Premium" class="btn btn-primary">Jetzt buchen</a>
                    <?php else: ?>
                        <p class="text-danger">Keine Zimmer dieser Auswahl verfügbar im gewählten Zeitraum.</p>
                    <?php endif; ?>
                </div>
            </div>

        <!-- Doppelzimmer Deluxe -->
        <div class="col-md-12 mb-4 d-flex align-items-center">
            <div class="carousel-container" style="flex: 1;">
                <div id="carouselExampleIndicators2" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="images/Hotel1_1.jpg" alt="Slide 1">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="images/Hotel2_7.jpg" alt="Slide 2">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators2" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators2" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </div>
            </div>
            <div class="card-body" style="flex: 1; padding-left: 20px;">
                <h5 class="card-title">Doppelzimmer Deluxe</h5>
                <p class="card-text">Genießen Sie ultimativen Komfort in unserem Doppelzimmer Deluxe, ausgestattet mit luxuriöser Einrichtung und atemberaubendem Blick auf die Natur.<br>(250€ pro Nacht)</p>
                <?php if (in_array(3, $freieZimmerIds) || in_array(4, $freieZimmerIds)): ?>
                        <a href="reservation.php ?checkin=<?php echo $checkin; ?>&checkout=<?php echo $checkout; ?>&guests=<?php echo $guests; ?>&zimmer=Doppelzimmer Deluxe" class= "btn btn-primary">Jetzt buchen</a>
                    <?php else: ?>
                        <p class="text-danger">Keine Zimmer dieser Auswahl verfügbar im gewählten Zeitraum.</p>
                    <?php endif; ?>
                </div>
           </div>

        <!-- Doppelzimmer Standard -->
        <div class="col-md-12 mb-4 d-flex align-items-center">
            <div class="carousel-container" style="flex: 1;">
                <div id="carouselExampleIndicators3" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="images/Hotel1_8.jpg" alt="Slide 1">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="images/Hotel2_6.jpg" alt="Slide 2">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators3" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators3" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </div>
            </div>
            <div class="card-body" style="flex: 1; padding-left: 20px;">
                <h5 class="card-title">Doppelzimmer Standard</h5>
                <p class="card-text">Unser Doppelzimmer Standard bietet Ihnen eine gemütliche Atmosphäre und ist ideal für Reisende, die eine praktische und komfortable Unterkunft suchen.<br>(200€ pro Nacht)</p>
                <?php if (in_array(5, $freieZimmerIds) || in_array(6, $freieZimmerIds)): ?>
                        <a href="reservation.php?checkin=<?php echo $checkin; ?>&checkout=<?php echo $checkout; ?>&guests=<?php echo $guests; ?>&zimmer=Doppelzimmer Standard" class="btn btn-primary">Jetzt buchen</a>
                    <?php else: ?>
                        <p class="text-danger">Keine Zimmer dieser Auswahl verfügbar im gewählten Zeitraum.</p>
                    <?php endif; ?>
                </div>
            </div>

        <!-- Einzelzimmer Premium -->
        <div class="col-md-12 mb-4 d-flex align-items-center">
            <div class="carousel-container" style="flex: 1;">
                <div id="carouselExampleIndicators6" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="images/Einzelzimmer3_3.jpg" alt="Slide 1">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="images/Einzelzimmer3_2.jpg" alt="Slide 2">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators6" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators6" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </div>
            </div>
            <div class="card-body" style="flex: 1; padding-left: 20px;">
                <h5 class="card-title">Einzelzimmer Premium</h5>
                <p class="card-text">Ein stilvoll eingerichtetes Einzelzimmer mit gemütlichem Einzelbett und einem funktionalen Schreibtisch. Die moderne Ausstattung ist ideal für eine Auszeit nach einem langen Tag.<br>(250€ pro Nacht)</p>
                <?php if ($guests > 1): ?>
                            <p class="text-info">Für 2 Gäste stehen unsere Doppelzimmer zur Verfügung.</p>
                        <?php elseif (in_array(7, $freieZimmerIds) || in_array(8, $freieZimmerIds)): ?>
                            <a href="reservation.php?checkin=<?php echo $checkin; ?>&checkout=<?php echo $checkout; ?>&guests=<?php echo $guests; ?>&zimmer=Einzelzimmer Deluxe" class="btn btn-primary">Jetzt buchen</a>
                        <?php else: ?>
                            <p class="text-danger">Keine Zimmer dieser Auswahl verfügbar im gewählten Zeitraum.</p>
                        <?php endif; ?>
                </div>
            </div>

        <!-- Einzelzimmer Deluxe -->
        <div class="col-md-12 mb-4 d-flex align-items-center">
            <div class="carousel-container" style="flex: 1;">
                <div id="carouselExampleIndicators4" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="images/Einzelzimmer1_1.jpg" alt="Slide 1">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="images/Einzelzimmer1_2.jpg" alt="Slide 2">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators4" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators4" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </div>
            </div>
            <div class="card-body" style="flex: 1; padding-left: 20px;">
                <h5 class="card-title">Einzelzimmer Deluxe</h5>
                <p class="card-text">Helles, modern eingerichtetes Zimmer mit komfortablem Einzelbett, Schreibtisch und eigenem Bad. Perfekt für Geschäftsreisende und Alleinreisende, die Ruhe und Funktionalität schätzen.<br>(200€ pro Nacht)</p>
                <?php if ($guests > 1): ?>
                            <p class="text-info">Für 2 Gäste stehen unsere Doppelzimmer zur Verfügung.</p>
                        <?php elseif (in_array(9, $freieZimmerIds) || in_array(10, $freieZimmerIds)): ?>
                            <a href="reservation.php?checkin=<?php echo $checkin; ?>&checkout=<?php echo $checkout; ?>&guests=<?php echo $guests; ?>&zimmer=Einzelzimmer Deluxe" class="btn btn-primary">Jetzt buchen</a>
                        <?php else: ?>
                            <p class="text-danger">Keine Zimmer dieser Auswahl verfügbar im gewählten Zeitraum.</p>
                        <?php endif; ?>
                </div>
            </div>

        <!-- Einzelzimmer Standard -->
        <div class="col-md-12 mb-4 d-flex align-items-center">
                <div class="carousel-container" style="flex: 1;">
                    <div id="carouselExampleIndicators5" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="images/Einzelzimmer2_3.jpg" alt="Slide 1">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="images/Einzelzimmer2_4.jpg" alt="Slide 2">
                            </div>
                        </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators5" role="button" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators5" role="button" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </a>
                     </div>
                        </div>
                        <div class="card-body" style="flex: 1; padding-left: 20px;">
                        <h5 class="card-title">Einzelzimmer Standard</h5>
                        <p class="card-text">Charmantes Zimmer mit bequemer Ausstattung, einem Einzelbett und stilvollem Dekor. Mit Flachbild-TV, Schreibtisch und eigenem Bad ideal für entspannte Aufenthalte.<br>(150€ pro Nacht)</p>
                        <?php if ($guests > 1): ?>
                            <p class="text-info">Für 2 Gäste stehen unsere Doppelzimmer zur Verfügung.</p>
                        <?php elseif (in_array(11, $freieZimmerIds) || in_array(12, $freieZimmerIds)): ?>
                            <a href="reservation.php?checkin=<?php echo $checkin; ?>&checkout=<?php echo $checkout; ?>&guests=<?php echo $guests; ?>&zimmer=Einzelzimmer Standard" class="btn btn-primary">Jetzt buchen</a>
                        <?php else: ?>
                            <p class="text-danger">Keine Zimmer dieser Auswahl verfügbar im gewählten Zeitraum.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3">
    <p>&copy; 2024 Traumzimmer. Alle Rechte vorbehalten.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JTq9ObeU1iYqCzzZmcNzPqL1cqk7kdsLO5cp8XMVo9O64eOuH0uZ8LtAc7YPFw7x" crossorigin="anonymous"></script>
</body>
</html>