<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once(__DIR__ . "/bdd.php"); 

$page = basename($_SERVER['PHP_SELF']);
$body_class = ''; 

if ($page == 'index.php') {
    $body_class = 'home';
} elseif ($page == 'inscription.php') {
    $body_class = 'page-inscription-bg';
} elseif ($page == 'connexion.php') {
    $body_class = 'page-connexion-bg';
} elseif ($page == 'reservation.php') {
    $body_class = 'page-reservation-bg';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAE202 - Escape Game de Nuit</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body class="<?php echo $body_class; ?>">

<div id="preloader">
   <img src="images/night_casino.png" alt="Logo Night Casino" class="preloader-logo">
    <nav class="preloader-nav">
        <a href="index.php">Accueil</a>
        <a href="concept.php">Concept</a>
        <a href="infos_pratiques.php">Infos Pratiques</a>
        <a href="connexion.php">Connexion</a>
    </nav>
</div>

<header>
    <div class="logo">
        <a href="index.php">
            <picture>
                <source media="(max-width: 768px)" srcset="images/logo_mobil.png">
                <img src="images/night_casino.png" alt="Logo Night Casino" class="header-logo-img">
            </picture>
        </a>
    </div>    
    
    <button class="hamburger-btn" aria-label="Menu de navigation">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </button>

    <nav class="nav-container">
        <ul class="nav-icones">
            <li>
                <a href="index.php" class="lien-icone" title="Accueil">
                    <img src="images/accueil.png" alt="Accueil" class="icon-nav">
                    <span class="tooltip-nav">Accueil</span>
                </a>
            </li>
            <li>
                <a href="concept.php" class="lien-icone" title="Concept">
                    <img src="images/concept.png" alt="Concept" class="icon-nav">
                    <span class="tooltip-nav">Concept</span>
                </a>
            </li>
            <li>
                <a href="infos_pratiques.php" class="lien-icone" title="Informations pratiques">
                    <img src="images/loupe.png" alt="Informations pratiques" class="icon-nav">
                    <span class="tooltip-nav">Informations</span>
                </a>
            </li>
            <li class="profile-menu">
                <a href="#" class="lien-icone" title="Connexion / Profil">
                    <img src="images/profil.png" alt="Connexion" class="icon-nav">
                    <span class="tooltip-nav">Connexion</span>
                </a>
                <div class="dropdown-content">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="profil.php">Mon profil</a>
                        <a href="reservation.php">Réservation</a>
                        <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
                            <a href="admin.php">Administration</a>
                        <?php endif; ?>
                        <a href="deconnexion.php">Déconnexion</a>
                    <?php else: ?>
                        <a href="connexion.php">Connexion</a>
                        <a href="inscription.php">Inscription</a>
                    <?php endif; ?>
                </div>
            </li>
        </ul>
    </nav>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const profileMenu = document.querySelector('.profile-menu');
    if (profileMenu) {
        const dropdown = profileMenu.querySelector('.dropdown-content');
        profileMenu.addEventListener('click', function(event) {
            if (event.target.closest('a.lien-icone')) {
                event.preventDefault();
                dropdown.classList.toggle('show');
            }
        });
        window.addEventListener('click', function(event) {
            if (!profileMenu.contains(event.target)) {
                if (dropdown.classList.contains('show')) {
                    dropdown.classList.remove('show');
                }
            }
        });
    }
});
</script>