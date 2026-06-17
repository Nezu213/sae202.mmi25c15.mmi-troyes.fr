<?php include_once("view/header.php"); ?>

<main class="page-concept-unique">
    <div class="container-concept">

        <h1 class="titre-concept">LE CONCEPT</h1>

        <!-- SCÉNARIO -->
        <section class="section-concept-bloc">
            <h2 class="sous-titre-concept">SCÉNARIO</h2>
            <img class="vague-delimite" src="images/vague.png" alt="délimitation">
            
            <div class="conteneur-split-scenario">
                <div class="colonne-texte-scenario">
                    <p>
                        Au sous-sol d'un hôtel de prestige se cache un casino clandestin...
                        8 à 10 personnes sont conviées à jouer sans savoir qu'une terrible nuit les attend.
                        Le dîner ne se passe pas comme prévu : une personne manque à l'appel, un meurtre a lieu,
                        et l'un d'eux est coupable. Mais ceci ne peut être une affaire policière…
                    </p>
                </div>
                <div class="colonne-image-scenario">
                    <img src="images/scenario.png" alt="Image du Scénario" class="concept-image-rounded">
                </div>
            </div>
        </section>

        <!-- CONDITIONS -->
        <section class="section-concept-bloc">
            <h2 class="sous-titre-concept">CONDITIONS</h2>
            <img class="vague-delimite-reverse" src="images/vague.png" alt="délimitation">
            
            <ul class="conditions-liste-pictos">
                <li><strong>ÉQUIPE :</strong> 8 à 10 joueurs</li>
                <li><strong>ÂGE MINIMUM :</strong> 18 ans</li>
                <li><strong>HANDICAP :</strong> Accessible PMR</li>
            </ul>
        </section>

        <!-- LES SERVICES -->
        <section class="section-concept-bloc">
            <h2 class="sous-titre-concept">LES SERVICES</h2>
            
            <div class="services-grille-casino">
                <div class="service-carte-casino">
                    <img src="images/couchage.png" alt="Couchage">
                    <p>Couchage</p>
                </div>
                <div class="service-carte-casino">
                    <img src="images/repas.png" alt="Repas">
                    <p>Repas</p>
                </div>
                <div class="service-carte-casino">
                    <img src="images/nettoyage.png" alt="Nettoyage">
                    <p>Nettoyage</p>
                </div>
            </div>
        </section>
        
        <img class="vague-delimite" src="images/vague.png" alt="délimitation">

        <!-- PLANNING -->
        <section class="section-concept-bloc">
            <h2 class="sous-titre-concept">PLANNING</h2>
            
            <div class="wrapper-cadre-planning-casino">
                <div class="contenu-planning-interne">
                    <h3>TABLEAU PLANNING</h3>
                </div>
            </div>
        </section>

        <!-- INTERDICTIONS -->
        <section class="section-concept-bloc section-interdictions-wrapper">
            <!-- Ajout d'une classe pour contrôler l'image sur mobile -->
            <img src="images/interdictions.png" alt="interdictions" class="img-interdictions-responsive">
        </section>

    </div>
</main>

<script src="js/script.js"></script>

<?php include_once("view/footer.php"); ?>