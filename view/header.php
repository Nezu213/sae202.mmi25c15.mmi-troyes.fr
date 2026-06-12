<?php include_once("view/bdd.php"); ?>
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
<?php
$page = basename($_SERVER['PHP_SELF']);
$body_class = ($page == 'index.php') ? 'home' : '';
?>
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
            <img src="images/night_casino.png" alt="Logo Night Casino">
        </a>
    </div>
    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="concept.php">Concept</a></li>
            <li><a href="infos_pratiques.php">Infos Pratiques</a></li>
            <li><a href="reservation.php">Réservation</a></li>
            <li class="profile-menu">
                <a href="#" class="lien-profil" title="Connexion / Profil">
                    <img src="images/profil.png" alt="Profil" width="24" height="24" class="icon-profil">
                </a>
                <div class="dropdown-content">
                    <a href="connexion.php">Connexion</a>
                    <a href="inscription.php">Inscription</a>
                </div>
            </li>
        </ul>
    </nav>
</header>