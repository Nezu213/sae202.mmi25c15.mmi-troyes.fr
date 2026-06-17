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
            <video controls poster="images/.png" width="100%">
                <source src="videos/night_casino_promo.mp4" type="video/mp4">
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

    <!-- ===========================================
         SECTION AVIS (Livre d'Or)
    ============================================ -->
    <section class="section-livre-or">
        <div class="liste-avis-maquette">
            <?php if (!empty($liste_avis)): ?>
                <?php foreach ($liste_avis as $un_avis): 
                    $note = intval($un_avis['note'] ?? $un_avis['nb_etoiles'] ?? 5);
                    $commentaire = htmlspecialchars($un_avis['commentaire'] ?? $un_avis['texte'] ?? '');

                    $pseudo = '';
                    if (!empty($un_avis['pseudo'])) { $pseudo = $un_avis['pseudo']; }
                    elseif (!empty($un_avis['nom'])) { $pseudo = $un_avis['nom']; }
                    elseif (!empty($un_avis['prenom'])) { $pseudo = $un_avis['prenom']; }
                    elseif (!empty($un_avis['login'])) { $pseudo = $un_avis['login']; }
                    elseif (!empty($un_avis['username'])) { $pseudo = $un_avis['username']; }
                    elseif (!empty($un_avis['id_utilisateur'])) { $pseudo = "Joueur #" . $un_avis['id_utilisateur']; }
                    else { $pseudo = 'Joueur'; }

                    $pseudo = htmlspecialchars($pseudo);
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
    </section>
</main>

<?php include_once("view/footer.php"); ?>