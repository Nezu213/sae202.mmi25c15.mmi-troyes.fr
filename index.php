<?php include_once("view/header.php"); ?>

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
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam.</p>
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
                <p>Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat.</p>
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
                <p>Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue. Ut in risus volutpat libero pharetra tempor.</p>
            </div>
        </div>
    </section>
</main>

<?php include_once("view/footer.php"); ?>