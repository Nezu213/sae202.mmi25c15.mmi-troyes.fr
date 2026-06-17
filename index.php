<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "model/avis_model.php";
$liste_avis = get_avis_approuves(5);
$avis_msg = $_SESSION['avis_msg'] ?? null;
unset($_SESSION['avis_msg']);
include_once("view/header.php");
?>

<style>
/* Style spécifique pour le système de notation par piques */
.rating-piques-container {
    display: flex;
    flex-direction: row-reverse;
    justify-content: center;
    gap: 8px;
    margin: 20px 0;
}

.rating-piques-container input[type="radio"] {
    display: none;
}

.rating-piques-container label {
    cursor: pointer;
    width: 40px;
    height: 40px;
    background-image: url('images/pique.png');
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    transition: transform 0.2s ease;
}

.rating-piques-container label:hover,
.rating-piques-container label:hover ~ label,
.rating-piques-container input[type="radio"]:checked ~ label {
    background-image: url('images/pique_dore.png');
    transform: scale(1.1);
}
</style>

<main>
    <h2>Bienvenue à l'Événement de l'Année</h2>
    <p style="text-align:center;">Découvrez notre escape game nocturne immersif.</p>

    <section class="hero-ambiance">
        <h2>Une aventure immersive</h2>
        <div class="cadre-ambiance">
            <p class="storytelling">
                Au sous-sol d'un hôtel de prestige se cache un casino clandestin...
                8 à 10 personnes sont conviées à jouer sans savoir qu'une terrible nuit les attend.
                Le dîner ne se passe pas comme prévu : une personne manque à l'appel, un meurtre a lieu,
                et l'un d'eux est coupable. Mais ceci ne peut être une affaire policière…
            </p>
            <p class="slogan-accueil">
                Alors, qui trouvera l'assassin… qui réussira à sortir vivant de cette prétendue soirée jeux ?
            </p>
        </div>
    </section>

    <section class="section-video">
        <h3>Bande-annonce officielle</h3>
        <div class="conteneur-video-169">
            <video controls width="100%">
                <source src="videos/video_nightCasino.webm" type="video/webm">
                <source src="videos/video_nightCasino.mp4" type="video/mp4">
                Votre navigateur ne prend pas en charge la lecture de cette vidéo.
            </video>
        </div>
        <p class="video-legende">Découvrez l'ambiance clandestine et mystérieuse du Night Casino avant de réserver votre table.</p>
    </section>

    <section class="modes-jeu">
        <h2>Faites vos jeux...</h2>

        <div class="grille-versions">
            <div class="carte-version">
                <div class="carte-version-image">
                    <img src="images/image_facile.jpg" alt="Version Facile">
                    <p class="titre-version-top">Version facile</p>
                    <a href="#version-facile" class="voir-plus-btn">Voir plus</a>
                </div>
            </div>
            
            <div class="carte-version">
                <div class="carte-version-image">
                    <img src="images/image_intermediaire.jpg" alt="Version Intermédiaire">
                    <p class="titre-version-top">Version intermédiaire</p>
                    <a href="#version-intermediaire" class="voir-plus-btn">Voir plus</a>
                </div>
            </div>

            <div class="carte-version">
                <div class="carte-version-image">
                    <img src="images/image_hardcore.jpg" alt="Version Hardcore">
                    <p class="titre-version-top">Version hardcore</p>
                    <a href="#version-hardcore" class="voir-plus-btn">Voir plus</a>
                </div>
            </div>
        </div>
    </section>
    
    <section id="version-facile" class="section-detail-version">
        <div class="conteneur-split">
            <div class="colonne-gauche">
                <img src="images/image_facile.jpg" alt="Illustration Version Facile">
            </div>
            <div class="colonne-droite">
                <h3>Version Facile</h3>
                <p>Idéal pour s'initier aux règles et peaufiner vos premières stratégies sans prendre de risques. Les jetons coulent à flot, l'ambiance est détendue et les croupiers se montrent particulièrement indulgents avec les nouveaux visages du Night Casino.</p>
            </div>
        </div>
    </section>

    <section id="version-intermediaire" class="section-detail-version">
        <div class="conteneur-split">
            <div class="colonne-gauche">
                <h3>Version Intermédiaire</h3>
                <p>L'expérience authentique du Night Casino. Trouvez le parfait équilibre entre adrénaline et contrôle avec des règles de jeu classiques et des tables équilibrées. C'est ici que se forgent les véritables légendes du tapis noir.</p>
            </div>
            <div class="colonne-droite">
                <img src="images/image_intermediaire.jpg" alt="Illustration Version Intermédiaire">
            </div>
        </div>
    </section>

    <section id="version-hardcore" class="section-detail-version">
        <div class="conteneur-split">
            <div class="colonne-gauche">
                <img src="images/image_hardcore.jpg" alt="Illustration Version Hardcore">
            </div>
            <div class="colonne-droite">
                <h3>Version Hardcore</h3>
                <p>Réservé aux flambeurs d'élite et aux joueurs aguerris. Ici, les mises de départ sont multipliées par 10, le bluff est un art de vivre et la moindre erreur peut vider votre bankroll en un clin d'œil. Serez-vous de taille face aux requins du tapis vert ?</p>
            </div>
        </div>
    </section>

    <section class="section-livre-or">
        <?php if (!empty($avis_msg)): ?>
            <p style="text-align: center; color: #ecd499; font-weight: bold; margin-bottom: 20px;"><?= htmlspecialchars($avis_msg) ?></p>
        <?php endif; ?>

        <div class="liste-avis-maquette">
            <?php if (!empty($liste_avis)): ?>
                <?php foreach ($liste_avis as $un_avis): 
                    $note = intval($un_avis['note'] ?? 5);
                    $commentaire = htmlspecialchars($un_avis['commentaire'] ?? '');
                    $pseudo = htmlspecialchars($un_avis['user_pseudo'] ?? 'Joueur');
                ?>
                    <div class="item-avis-unique">
                        <div class="entete-avis-ligne">
                            <div class="piques-notation-wrapper">
                                <?php
                                for ($i = 1; $i <= $note; $i++) {
                                    echo '<img src="images/pique_dore.png" alt="As Pique Doré" class="pique-icone">';
                                }
                                for ($j = $note + 1; $j <= 5; $j++) {
                                    echo '<img src="images/pique.png" alt="As Pique Noir" class="pique-icone">';
                                }
                                ?>
                            </div>
                            <h4 class="nom-auteur-avis"><?php echo $pseudo; ?></h4>
                        </div>
                        <p class="texte-corps-avis"><?php echo $commentaire; ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align: center; color: #ecd499; font-style: italic;">Aucun avis pour le moment.</p>
            <?php endif; ?>
        </div>

        <div class="formulaire-notation-index" style="margin-top: 40px;">
            <?php if (isset($_SESSION['pseudo'])): ?>
                <form action="controller/avis_controller.php" method="POST" style="max-width: 600px; margin: 0 auto; padding: 20px; background: #1a0f0f; border: 1px solid #ecd499; border-radius: 8px;">
                    <h3 style="color: #ecd499; text-align: center; margin-top: 0;">Laissez votre avis</h3>
                    
                    <div class="rating-piques-container">
                        <input type="radio" id="pique5" name="note" value="5" checked /><label for="pique5" title="5 piques"></label>
                        <input type="radio" id="pique4" name="note" value="4" /><label for="pique4" title="4 piques"></label>
                        <input type="radio" id="pique3" name="note" value="3" /><label for="pique3" title="3 piques"></label>
                        <input type="radio" id="pique2" name="note" value="2" /><label for="pique2" title="2 piques"></label>
                        <input type="radio" id="pique1" name="note" value="1" /><label for="pique1" title="1 pique"></label>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <textarea name="commentaire" rows="4" required style="width: 100%; padding: 10px; background: #331a1a; color: #fff; border: 1px solid #ecd499; border-radius: 4px; resize: none;" placeholder="Écrivez votre commentaire ici..."></textarea>
                    </div>

                    <button type="submit" style="width: 100%; padding: 10px; background: #ecd499; color: #1a0f0f; font-weight: bold; border: none; cursor: pointer;">
                        Envoyer
                    </button>
                </form>
            <?php else: ?>
                <p style="text-align: center; color: #ecd499; font-style: italic;">
                    Il faut se connecter pour pouvoir mettre un avis.
                </p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include_once("view/footer.php"); ?>