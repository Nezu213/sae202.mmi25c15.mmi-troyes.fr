<?php
// On démarre la session seulement si elle n'est pas déjà active.
// C'est la première chose à faire pour éviter les erreurs "headers already sent".
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("view/bdd.php"); 
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
        <ul class="nav-icones">
            <li>
                <a href="index.php" class="lien-icone" title="Accueil">
                    <img src="images/icone_accueil.png" alt="Accueil" class="icon-nav">
                    <span class="tooltip-nav">Accueil</span>
                </a>
            </li>
            <li>
                <a href="concept.php" class="lien-icone" title="Concept">
                    <img src="images/icone_concept.png" alt="Concept" class="icon-nav">
                    <span class="tooltip-nav">Concept</span>
                </a>
            </li>
            <li>
                <a href="infos_pratiques.php" class="lien-icone" title="Informations pratiques">
                    <img src="images/icone_infos.png" alt="Informations pratiques" class="icon-nav">
                    <span class="tooltip-nav">Informations</span>
                </a>
            </li>
            <li class="profile-menu">
                <a href="#" class="lien-icone" title="Connexion / Profil">
                    <img src="images/icone_connexion.png" alt="Connexion" class="icon-nav">
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
            // S'assurer que le clic vient bien de l'icône principale et non d'un lien dans le dropdown
            if (event.target.closest('a.lien-icone')) {
                event.preventDefault();
                dropdown.classList.toggle('show');
            }
        });

        // Fermer le menu si on clique n'importe où ailleurs sur la page
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