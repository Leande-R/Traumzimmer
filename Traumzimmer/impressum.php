<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impressum</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            padding-top: 100px;
            padding-bottom: 100px;
            background-color: #f8f9fa;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        h1 {
            margin-bottom: 20px;
            font-size: 2rem;
            color: 495057;
        }
        h2 {
            margin-top: 20px;
            font-size: 1.5rem;
            color: #495057;
        }
        p {
            margin-bottom: 10px;
            line-height: 1.6;
            color: #6c757d;
        }
        body {
            background-color: #8b768b00; 
        }
        p {
            margin-bottom: 10px;
            line-height: 1.6;
            color: #6c757d;
        }
        /* Spezifische CSS-Regeln für die Bilder */
        .owner-img {
            width: 400px;
            max-width: 200px;
            margin-bottom: 10px;
            object-fit: cover;
        }
        .owner-name {
            font-size: 1.1rem;
            color: #495057;
        }
    </style>
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <div class="container">
      <a class="navbar-brand" href="#">
          <img src="images/LogoBreit.png" alt="Logo" style="height: 60px;">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Deutsch
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                      <li><a class="dropdown-item" href="#" onclick="setLanguage('Englisch')">Englisch</a></li>
                  </ul>
              </li>
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Euro €
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                      <li><a class="dropdown-item" href="#" onclick="setCurrency">US-Dollar $</a></li>
                  </ul>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="login.php">
                      Einloggen <i class="fas fa-sign-in-alt"></i> <!-- Icon für Einloggen -->
                  </a>
              </li>
          </ul>
      </div>
  </div>
</nav>

<body>

<div class="container mt-5">
    <!-- Abschnitt für Eigentümer-Fotos -->
    <div class="row text-center mb-4">
        <div class="col-md-6">
          
            <img src="images/Eigentümerfoto1.jpg" alt="Oliver K." class="owner-img">
            <p class="owner-name">Oliver K.</p>
        </div>
        <div class="col-md-6">
            <img src="images/Eigentümerfoto2.jpg" alt="Leander R." class="owner-img">
            <p class="owner-name">Leander R.</p>
        </div>
    </div>

    <h1>Impressum</h1>
    <p><strong>Angaben gemäß § 5 TMG</strong></p>
    <p>Egon Kowalski<br>
    Karl-Gasse 1<br>
    1110 Wien<br>
    Österreich</p>

    <h2>Kontakt</h2>
    <p>Telefon: +43 1 9699090<br>
    E-Mail: Traumzimmer@urlaub.at</p>

    <h2>Bankverbindung</h2>
    <p>Hypo Alpe Adria Bank AG<br>
    <p>BLZ: 57000<br>
    <p>Konto-Nr:133117218<br>
    <p>IBAN: AT08 5700 14256 75489 4274<br>
    <p>BIC-Code: HYPTAT2222<br>

    <h2>Umsatzsteuer-ID</h2>
    <p>Umsatzsteuer-Identifikationsnummer gemäß §27 a Umsatzsteuergesetz:<br>
    <p>UID: ATU-47852<br>

    <h2>Haftung für Inhalte</h2>
    <p>Die Inhalte unserer Seiten wurden mit größter Sorgfalt erstellt. Für die Richtigkeit, Vollständigkeit und Aktualität der Inhalte können wir jedoch keine Gewähr übernehmen.</p>

    <h2>Haftung für Links</h2>
    <p>Unser Angebot enthält Links zu externen Websites Dritter, auf deren Inhalte wir keinen Einfluss haben. Deshalb können wir für diese fremden Inhalte auch keine Gewähr übernehmen.</p>

    <h2>Urheberrecht</h2>
    <p>Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem österreichischem Urheberrecht.</p>
</div>

<!-- Footer -->
<?php include 'footer.php'; ?> 

</body>
    </html>
