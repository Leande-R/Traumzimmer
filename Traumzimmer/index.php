<?php 
session_start();
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
            <form action="overview.php" method="get" class="row g-3 align-items-end">
                <!-- Dropdown für Anzahl der Gäste -->
                <div class="col-md-4">
                    <label for="guestsDropdown" class="form-label">Anzahl der Gäste</label>
                    <select name="guests" id="guestsDropdown" class="form-select">
                        <option value="1" selected>1 Gast</option>
                        <option value="2">2 Gäste</option>
                        <option value="3">3 Gäste</option>
                        <option value="4">4 Gäste</option>
                        <option value="5">5 Gäste</option>
                    </select>
                </div>

                <!-- Anreisedatum -->
                <div class="col-md-3">
                    <label for="checkin" class="form-label">Anreisedatum</label>
                    <input type="date" name="checkin" id="checkin" class="form-control" required>
                </div>

                <!-- Abreisedatum -->
                <div class="col-md-3">
                    <label for="checkout" class="form-label">Abreisedatum</label>
                    <input type="date" name="checkout" id="checkout" class="form-control" required>
                </div>

                <!-- Buchen-Button -->
                <div class="col-md-2 text-center">
                    <button type="submit" class="btn btn-primary w-100">buchen</button>
                </div>
            </form>
        </div>
    </div>
</section>

<div class="container my-5">
    <div class="row">
        <!-- Zimmerkarten (wie zuvor) -->
        <div class="col-md-4">
            <div class="card mb-4">
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
                <div class="card-body">
                    <h5 class="card-title">Doppel Zimmer Premium</h5>
                    <p class="card-text">Erleben Sie höchsten Wohnkomfort in unserem Doppelzimmer Premium, das stilvolle Akzente und moderne Annehmlichkeiten für einen unvergesslichen Aufenthalt bietet.</p>
                    <a href="DoppelZimmerPremium.php" class="btn btn-primary">Jetzt buchen</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
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
                <div class="card-body">
                    <h5 class="card-title">Doppel Zimmer Deluxe</h5>
                    <p class="card-text">Genießen Sie ultimativen Komfort in unserem Doppelzimmer Deluxe, ausgestattet mit luxuriöser Einrichtung und atemberaubendem Blick auf die Natur.</p>
                    <a href="DoppelZimmerDeluxe.php" class="btn btn-primary">Jetzt buchen</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
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
                <div class="card-body">
                    <h5 class="card-title">Doppel Zimmer Standard</h5>
                    <p class="card-text">Unser Doppelzimmer Standard bietet Ihnen eine gemütliche Atmosphäre und ist ideal für Reisende, die eine praktische und komfortable Unterkunft suchen.</p>
                    <a href="DoppelZimmerStandard.php" class="btn btn-primary">Jetzt buchen</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Neue Zeile mit Carouselen für Einzelzimmer -->
<div class="container my-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
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
                <div class="card-body">
                    <h5 class="card-title">Einzelzimmer 1</h5>
                    <p class="card-text">Genießen Sie ein gemütliches und modernes Einzelzimmer mit allen Annehmlichkeiten für einen entspannenden Aufenthalt.</p>
                    <a href="Einzelzimmer1.php" class="btn btn-primary">Jetzt buchen</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div id="carouselExampleIndicators5" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="images/Einzelzimmer2_1.jpg" alt="Slide 1">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="images/Einzelzimmer2_2.jpg" alt="Slide 2">
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
                <div class="card-body">
                    <h5 class="card-title">Einzelzimmer 2</h5>
                    <p class="card-text">Unsere Einzelzimmer 2 bieten Ihnen viel Komfort und Ruhe für Ihren Aufenthalt.</p>
                    <a href="Einzelzimmer2.php" class="btn btn-primary">Jetzt buchen</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div id="carouselExampleIndicators6" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="images/Einzelzimmer3_1.jpg" alt="Slide 1">
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
                <div class="card-body">
                    <h5 class="card-title">Einzelzimmer 3</h5>
                    <p class="card-text">Einzelzimmer 3 bieten Komfort und eine ruhige Atmosphäre für Geschäftsreisende und Erholungssuchende.</p>
                    <a href="Einzelzimmer3.php" class="btn btn-primary">Jetzt buchen</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
