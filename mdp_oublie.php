<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("view/header.php"); 
?>

<main class="page-mdp-oublie-unique">
    <div class="container-mdp-oublie">
        
        <h1 class="titre-mdp-oublie">RÉCUPÉRATION</h1>

        <!-- Gestion des messages d'erreur ou de succès -->
        <?php if (isset($_GET['error']) && $_GET['error'] === 'not_found'): ?>
            <div class="msg-error-box">
                ❌ Cet e-mail n'est pas enregistré au casino.
            </div>
        <?php elseif (isset($_GET['success']) && $_GET['success'] === 'sent'): ?>
            <div class="msg-success-box">
                ✨ Un lien de réinitialisation vous a été envoyé par e-mail !
            </div>
        <?php endif; ?>

        <!-- Le Cadre Principal -->
        <div class="wrapper-cadre-mdp-oublie">
            <form action="controller/mdp_oublie_controller.php" method="POST" class="form-mdp-oublie" autocomplete="off">
                
                <p class="consigne-recup">
                    Entrez l'adresse e-mail du responsable de l'équipe pour recevoir un lien de récupération.
                </p>

                <div class="input-group-mdp-oublie">
                    <label for="email">E-mail du responsable</label>
                    <!-- Input utilisant grand_rectV2.png -->
                    <input type="email" id="email" name="email" class="input-mdp-oublie-grand" required>
                </div>
                
                <div class="navigation-liens">
                    <a href="connexion.php" class="lien-retour">Retour à la connexion</a>
                </div>
                
                <button type="submit" class="btn-valider-mdp-oublie">Envoyer le lien</button>
            </form>
        </div>

    </div>
</main>

<script src="js/script.js"></script>

<?php include_once("view/footer.php"); ?>