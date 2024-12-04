<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traumzimmer FAQ</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        
        nav ul {
            list-style-type: none;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin-right: 10px;
        }
        nav ul li a {
            text-decoration: none;
            color: #007BFF;
        }
        .faq-section h2 {
            margin-bottom: 20px;
        }
        .faq h3 {
            cursor: pointer;
            color: #007BFF;
        }
        header {
            text-align: center;
            padding: 50px 0; /* Reduziert den Abstand nach dem Header */
        }
        footer {
            background-color: #333; /* Dunkle Hintergrundfarbe */
            color: #fff; /* Weiße Schrift */
            text-align: center;
            padding: 10px 0;
            position: relative;
        }
        footer a {
            color: #ffc107; /* Linkfarbe im Footer */
            text-decoration: none;
        }
    </style>
</head>
<body>

    <?php include 'navbar.php'; ?> <!-- Include the navbar -->

    <header>
        <h1>Traumzimmer FAQ</h1>
    </header>

    <div class="container">
        <section class="faq-section">
            <h2>Häufige Fragen</h2>
            <div class="faq">
                <h3 data-toggle="collapse" data-target="#faq1" aria-expanded="false" aria-controls="faq1">Wie buche ich ein Zimmer?</h3>
                <div id="faq1" class="collapse">
                    <p>Um ein Zimmer zu buchen, wählen Sie Ihr gewünschtes Datum und Zimmerkategorie. Folgen Sie den Anweisungen zur Bestätigung der Buchung.</p>
                </div>
            </div>
            <div class="faq">
                <h3 data-toggle="collapse" data-target="#faq2" aria-expanded="false" aria-controls="faq2">Welche Zahlungsmethoden werden akzeptiert?</h3>
                <div id="faq2" class="collapse">
                    <p>Wir akzeptieren Kreditkarte, PayPal und Banküberweisung. Details zur Zahlung finden Sie während des Buchungsprozesses.</p>
                </div>
            </div>
            <div class="faq">
                <h3 data-toggle="collapse" data-target="#faq3" aria-expanded="false" aria-controls="faq3">Kann ich meine Buchung stornieren oder ändern?</h3>
                <div id="faq3" class="collapse">
                    <p>Ja, 2 Wochen vor Antritt der Reise ist eine Stornierung kostenfrei möglich.</p>
                </div>
            </div>
            <div class="faq">
                <h3 data-toggle="collapse" data-target="#faq4" aria-expanded="false" aria-controls="faq4">Wann erhalte ich eine Bestätigung meiner Buchung?</h3>
                <div id="faq4" class="collapse">
                    <p>Sobald Sie die Buchung abgeschlossen haben, erhalten Sie innerhalb weniger Minuten eine Bestätigung per E-Mail mit allen Details.</p>
                </div>
            </div>
            <div class="faq">
                <h3 data-toggle="collapse" data-target="#faq5" aria-expanded="false" aria-controls="faq5">Wie kann ich spezielle Wünsche oder Anfragen stellen?</h3>
                <div id="faq5" class="collapse">
                    <p>Sie können während des Buchungsprozesses spezielle Wünsche angeben oder uns direkt per E-Mail oder Telefon kontaktieren, um zusätzliche Anfragen zu besprechen.</p>
                </div>
            </div>
        </section>
    </div>


</body>
        <!-- Footer -->
    <?php include 'footer.php'; ?>

</html>
