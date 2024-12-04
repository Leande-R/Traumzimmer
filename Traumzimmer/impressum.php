<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impressum</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            padding-top: 100px;
            padding-bottom: 100px;
            background-color: #f8f9fa; /* Neutral background color */
        }
      
        h1, h2 {
            color: #495057;
        }
        h1 {
            margin-bottom: 20px;
            font-size: 2rem;
        }
        h2 {
            margin-top: 20px;
            font-size: 1.5rem;
        }
        p {
            line-height: 1.6;
            color: #6c757d;
        }
        .owner-img {
            width: 200px; /* Fix consistent width */
            height: auto;
            margin-bottom: 10px;
            object-fit: cover;
            border-radius: 8px; /* Rounded corners for better aesthetics */
        }
        .owner-name {
            font-size: 1.1rem;
            color: #495057;
        }
    </style>
</head>
<body>

<!-- Include Navbar -->
<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <!-- Eigentümer-Fotos -->
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
    BLZ: 57000<br>
    Konto-Nr: 133117218<br>
    IBAN: AT08 5700 14256 75489 4274<br>
    BIC-Code: HYPTAT2222</p>

    <h2>Umsatzsteuer-ID</h2>
    <p>Umsatzsteuer-Identifikationsnummer gemäß § 27 a Umsatzsteuergesetz:<br>
    UID: ATU-47852</p>

    <h2>Haftung für Inhalte</h2>
    <p>Die Inhalte unserer Seiten wurden mit größter Sorgfalt erstellt. Für die Richtigkeit, Vollständigkeit und Aktualität der Inhalte können wir jedoch keine Gewähr übernehmen.</p>

    <h2>Haftung für Links</h2>
    <p>Unser Angebot enthält Links zu externen Websites Dritter, auf deren Inhalte wir keinen Einfluss haben. Deshalb können wir für diese fremden Inhalte auch keine Gewähr übernehmen.</p>

    <h2>Urheberrecht</h2>
    <p>Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem österreichischen Urheberrecht.</p>
</div>

<!-- Include Footer -->
<?php include 'footer.php'; ?>

<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
