<?php


// On vérifie si l'utilisateur essaie d'appeler une page via l'URL
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    // On nettoie le nom de la page pour éviter les piratages de type "injections"
    $page = preg_replace('/[^a-zA-Z0-9_-]/', '', $page);
    
    // Si le fichier n'existe pas, on redirige vers notre 404
    if ($page !== '' && !file_exists($page . '.php')) {
        include_once("404.php");
        exit();
    }
}


// On démarre la session seulement si elle n'est pas déjà active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("view/header.php");
require_once("model/avis_model.php");

// Récupérer les avis approuvés pour les afficher
$liste_avis = get_avis_approuves();

// Gérer les messages de retour du formulaire d'avis
$avis_msg = $_GET['avis'] ?? ''; 
?>
<main>
    <h2>Bienvenue à l'Événement de l'Année</h2>
    <p>Découvrez notre escape game nocturne immersif.</p>
    
    <section class="hero-ambiance">
        <h2>UNE AVENTURE IMMERSIVE</h2>
        <div class="cadre-ambiance">
            <p class="storytelling">
                Au sous-sol d’un hôtel de prestige se cache un casino clandestin... 
                8 à 10 personnes sont conviées à jouer sans savoir qu’une terrible nuit les attend. 
                Le dîner ne se passe pas comme prévu : une personne manque à l'appel, un meurtre a lieu, 
                et l’un d'eux est coupable. Mais ceci ne peut être une affaire policière…
            </p>
            <p class="slogan-accueil">Alors, qui trouvera l'assassin… qui réussira à sortir vivant de cette prétendue soirée jeux ?</p>
        </div>
    </section>

    <section class="section-video">
        <h3>BANDE-ANNONCE OFFICIELLE</h3>
        <div class="conteneur-video-169">
            <video controls poster="images/image_casino.jpg" width="100%">
                <source src="videos/night_casino_promo.mp4" type="video/mp4">
                Votre navigateur ne prend pas en charge la lecture de cette vidéo.
            </video>
        </div>
        <p class="video-legende">Découvrez l'ambiance clandestine et mystérieuse du Night Casino avant de réserver votre table.</p>
    </section>

    <section class="modes-jeu">
        <h2>FAITES VOS JEUX...</h2>

        <div class="mode-carte">
            <h3>TRAILER</h3>
            <p>Plongez dans l'ambiance de notre casino clandestin.</p>
        </div>

        <div class="grille-versions">
            <div class="carte-version">
                <div class="carte-version-image">
                    <img src="images/image_facile.jpg" alt="Version Facile">
                    <a href="#version-facile" class="voir-plus-btn">Voir plus</a>
                </div>
                <p>Version Facile</p>
            </div>
            <div class="carte-version">
                <div class="carte-version-image">
                    <img src="images/image_intermediaire.jpg" alt="Version Intermédiaire">
                    <a href="#version-intermediaire" class="voir-plus-btn">Voir plus</a>
                </div>
                <p>Version Intermédiaire</p>
            </div>
            <div class="carte-version">
                <div class="carte-version-image">
                    <img src="images/image_hardcore.jpg" alt="Version Hardcore">
                    <a href="#version-hardcore" class="voir-plus-btn">Voir plus</a>
                </div>
                <p>Version Hardcore</p>
            </div>
        </div>
    </section>

    <section id="version-facile" class="section-detail-version">
        <div class="conteneur-split">
            <div class="colonne-gauche">
                <img src="images/image_facile.jpg" alt="Illustration Version Facile">
            </div>
            <div class="colonne-droite">
                <h3>VERSION FACILE</h3>
                <p>Découvrez une enquête accessible à tous, idéale pour s'initier aux secrets du casino clandestin. Les indices sont clairs et l'intrigue fluide pour vous permettre de savourer l'aventure sans bloquer sur les rouages du mystère.</p>
            </div>
        </div>
    </section>

    <section id="version-intermediaire" class="section-detail-version">
        <div class="conteneur-split">
            <div class="colonne-gauche">
                <img src="images/image_intermediaire.jpg" alt="Illustration Version Intermédiaire">
            </div>
            <div class="colonne-droite">
                <h3>VERSION INTERMÉDIAIRE</h3>
                <p>Le juste équilibre entre réflexion et immersion. Les énigmes demandent une véritable cohésion d'équipe et un sens de l'observation aiguisé. Parfait pour les joueurs cherchant un défi à la hauteur du crime commis.</p>
            </div>
        </div>
    </section>

    <section id="version-hardcore" class="section-detail-version">
        <div class="conteneur-split">
            <div class="colonne-gauche">
                <img src="images/image_hardcore.jpg" alt="Illustration Version Hardcore">
            </div>
            <div class="colonne-droite">
                <h3>VERSION HARDCORE</h3>
                <p>Réservé aux enquêteurs d'élite. Le temps presse, les fausses pistes sont légion et le coupable fera tout pour vous faire accuser. Serez-vous capables de démasquer l'assassin avant qu'il ne s'en prenne à vous ?</p>
            </div>
        </div>
    </section>

    <section id="avis" class="section-avis">
        <h2>Avis</h2>
        <div class="separateur-or"></div>

        <?php if (isset($_SESSION['user_id'])): ?>
            
            <?php if ($avis_msg === 'success'): ?>
                <div style="background: rgba(46, 204, 113, 0.15); color: #2ecc71; border: 1px solid #2ecc71; padding: 15px; font-weight: bold; margin: 20px auto; text-align: center; max-width: 600px; border-radius: 4px;">
                    Merci ! Votre avis a été transmis avec succès. Il apparaîtra ici après vérification et validation par le croupier.
                </div>
            <?php elseif ($avis_msg === 'error'): ?>
                <div style="background: rgba(231, 76, 60, 0.15); color: #e74c3c; border: 1px solid #e74c3c; padding: 15px; font-weight: bold; margin: 20px auto; text-align: center; max-width: 600px; border-radius: 4px;">
                    Une erreur est survenue. Veuillez vous assurer d'avoir écrit un commentaire avant de valider.
                </div>
            <?php endif; ?>

            <form action="controller/avis_controller.php" method="POST" class="form-avis">
                <div class="form-groupe">
                    <label for="note">Votre note</label>
                    <select name="note" id="note" required>
                        <option value="5">★★★★★ — Excellent</option>
                        <option value="4">★★★★☆ — Très bien</option>
                        <option value="3">★★★☆☆ — Correct</option>
                        <option value="2">★★☆☆☆ — Décevant</option>
                        <option value="1">★☆☆☆☆ — Mauvais</option>
                    </select>
                </div>
                <div class="form-groupe">
                    <label for="commentaire">Votre message</label>
                    <textarea name="commentaire" id="commentaire" rows="4" required placeholder="Partagez votre expérience..."></textarea>
                </div>
                <button type="submit" class="btn-reserver">Envoyer mon avis</button>
            </form>
        <?php else: ?>
            <p class="avis-connexion-message" style="text-align: center; margin: 20px 0;">
                Vous devez être <a href="connexion.php" style="color: #f1c40f; text-decoration: underline;">connecté</a> pour laisser un avis.
            </p>
        <?php endif; ?>

        <div class="liste-avis" style="margin-top: 30px;">
            <?php if (empty($liste_avis)): ?>
                <p class="avis-vide" style="text-align: center; font-style: italic; color: #888;">Aucun avis pour le moment. Soyez le premier à en laisser un !</p>
            <?php else: ?>
                <?php foreach ($liste_avis as $item): ?>
                    <div class="avis-item" style="background: #1a1a1a; padding: 20px; border: 1px solid #333; margin-bottom: 15px; border-radius: 4px;">
                        <div class="avis-header" style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                            <span class="avis-pseudo" style="font-weight: bold; color: #f1c40f;"><?php echo htmlspecialchars($item['user_pseudo'] ?? 'Équipe Anonyme'); ?></span>
                            <span class="avis-note" style="color: #f1c40f;">
                                <?php echo str_repeat('★', $item['note']) . str_repeat('☆', 5 - $item['note']); ?>
                            </span>
                        </div>
                        <p class="avis-commentaire" style="color: #eee; line-height: 1.5;"><?php echo nl2br(htmlspecialchars($item['commentaire'])); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</main> <?php include_once("view/footer.php"); ?>