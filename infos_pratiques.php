<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("view/header.php"); 
?>

<main class="page-infos-pratiques">
    
    <section class="section-infos-haute">
        <div class="content-limiteur">
            <h1 class="titre-infos">INFORMATIONS PRATIQUES</h1>
            <h2 class="sous-titre-infos">LE LIEU</h2>

            <div class="bloc-carte-ambiance">
                <div class="cadre-carte-epines">
                    <iframe 
                        src="https://maps.google.com/maps?q=Radisson%20Hotel%20Reims&t=&z=13&ie=UTF8&iwloc=&output=embed" 
                        width="100%" 
                        height="250" 
                        style="border:0; display:block;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                
                <div class="texte-lieu-droite">
                    <p>
                        C'est au cœur du Radisson Hotel de Reims, dans des salons habituellement
                        réservés aux réceptions les plus prestigieuses, que se cache notre casino
                        clandestin. Le décor authentique de l'établissement plonge les joueurs dans
                        une ambiance feutrée et chic, avant que la soirée ne bascule dans le mystère.
                    </p>
                    <p style="margin-top: 15px;">
                        L'adresse précise et les indications d'accès vous seront communiquées par
                        e-mail dès la confirmation de votre réservation, afin de préserver tout le
                        secret de l'expérience jusqu'au jour J.
                    </p>
                </div>
            </div>

            <img class="vague-delimite" src="images/vague.png" alt="délimitation">

            <div class="bloc-coordonnees-horaires">
                <div class="colonne-gauche-contacts">
                    <p><strong>Numéro de téléphone :</strong><br>03 26 00 00 00</p>
                    <p><strong>Adresse mail :</strong><br>contactnightcasino@gmail.com</p>
                    <p><strong>Horaires des Sessions :</strong><br>
                        Lundi : 19h30 - 23h30<br>
                        Mardi : 19h30 - 23h30<br>
                        Mercredi : 19h30 - 23h30<br>
                        Jeudi : 19h30 - 23h30<br>
                        Vendredi : 19h30 - 00h30
                    </p>
                </div>
                <div class="colonne-droite-description">
                    <p>
                        Nos équipes vous accueillent exclusivement sur réservation pour préserver le secret de l'organisation. Pour toute demande de privatisation d'entreprise ou d'événement de groupe supérieur à 10 personnes, veuillez nous contacter directement par e-mail afin d'obtenir un aménagement sur-mesure de nos salons clandestins.
                    </p>
                </div>
            </div>
        </div>
                <img class="vague-delimite-reverse" src="images/vague.png" alt="délimitation">

                    <section class="section-modalites">
        <div class="content-limiteur">
            <h2 class="titre-modalites">LES MODALITÉS</h2>
            
            <div class="texte-modalites-container">
                <p>
                    <strong>Déroulement de la soirée :</strong> Accueil des convives à 19h30 pour un
                    cocktail de bienvenue, suivi d'un dîner servi à 20h. C'est durant ce dîner que
                    l'intrigue se déclenche : une disparition, puis un meurtre. Les joueurs ont alors
                    jusqu'à 23h pour interroger, fouiller et démasquer le coupable avant que la police
                    ne soit alertée. La soirée se termine par la révélation du dénouement et la remise
                    des résultats de l'enquête.
                </p>
                <p style="margin-top: 20px;">
                    <strong>Conditions de réservation :</strong> Chaque session accueille de 8 à 10
                    joueurs, à partir de 18 ans. Une tenue correcte est demandée (élégante ou
                    thématique années folles, à votre convenance). Le règlement intégral est exigé
                    à la réservation ; toute annulation à moins de 7 jours de l'événement ne pourra
                    être remboursée. L'établissement est accessible aux personnes à mobilité réduite.
                </p>
                <p style="margin-top: 20px;">
                    <strong>Éléments prévus :</strong> Repas et boissons sont inclus dans le tarif de la
                    soirée. Téléphones, appareils photo et animaux ne sont pas autorisés dans l'espace
                    de jeu afin de préserver l'immersion de tous les participants.
                </p>
            </div>
        </div>
    </section>


    </section>
</main>

<script src="js/script.js"></script>
<?php include_once("view/footer.php"); ?>