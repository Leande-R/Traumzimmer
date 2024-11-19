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
                        <li><a class="dropdown-item" href="#" onclick="setLanguage('English')">English</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="currencyDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Euro €
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="currencyDropdown">
                        <li><a class="dropdown-item" href="#" onclick="setCurrency">US-Dollar $</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="LogIn.php">
                        Einloggen <i class="fas fa-sign-in-alt"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>