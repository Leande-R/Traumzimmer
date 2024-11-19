
<?php 

session_start();

/*session is started if you don't write this line can't use $_Session  global variable*/


?>
<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Traumzimmer - Ein Ort der Ruhe und Entspannung, an dem Träume zur Wirklichkeit werden</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css"> <!-- Link to styles.css -->
</head>

<body>

<?php include 'navbar.php'; ?> <!-- Include the navbar -->
    

<!-- Header-Bereich -->
 
<header class="header">
    <div class="container text-white text-center py-5">
        <h1>Willkommen bei Traumzimmer</h1>
        <p class="lead">Finden Sie Ihr perfektes Zimmer, um den Alltag hinter sich zu lassen!</p>
    </div>
</header>


<section class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <form class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="guestsRoomsDropdown" class="form-label">Gäste und Zimmer</label>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary w-100 dropdown-toggle" type="button" id="guestsRoomsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Gäste und Zimmer auswählen
                        </button>
                        <ul class="dropdown-menu p-3 w-100" aria-labelledby="guestsRoomsDropdown">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <label class="form-label mb-0">Anzahl der Gäste</label>
                                <div class="input-group" style="width: 120px;">
                                    <input type="number" class="form-control text-center" id="guestsCount" value="1" min="1" max="10" step="1">
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="form-label mb-0">Anzahl der Zimmer</label>
                                <div class="input-group" style="width: 120px;">
                                    <input type="number" class="form-control text-center" id="roomsCount" value="1" min="1" max="10" step="1">
                                </div>
                            </div>
                        </ul>
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="checkin" class="form-label">Anreisedatum</label>
                    <input type="date" class="form-control" id="checkin">
                </div>

                <div class="col-md-3">
                    <label for="checkout" class="form-label">Abreisedatum</label>
                    <input type="date" class="form-control" id="checkout">
                </div>

                <div class="col-md-2 text-center">
                    <button type="submit" class="btn btn-primary w-100">buchen</button>
                </div>
            </form>
        </div>
    </div>
</section>




<div class="container my-5">
    <div class="row">
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
                    <a href="#" class="btn btn-primary">Jetzt buchen</a>
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
                    <a href="#" class="btn btn-primary">Jetzt buchen</a>
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
                    <a href="#" class="btn btn-primary">Jetzt buchen</a>
                </div>
            </div>
        </div>

    </div>
</div>



<!-- Footer -->
<?php include 'footer.php'; ?> 



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>

