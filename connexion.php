<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Inclusion propre depuis la racine
include_once("view/header.php"); 
?>

<main class="page-connexion-unique">
    <div class="container-connexion">
        
        <h1 class="titre-connexion">CONNEXION</h1>

        <?php if (isset($_GET['error'])): ?>
            <div class="msg-error-box">
                ❌ L'identifiant (Nom d'équipe) ou le mot de passe est incorrect.
            </div>
        <?php endif; ?>

        <div class="wrapper-cadre-connexion">
            <form action="controller/connexion_controller.php" method="POST" class="form-connexion" autocomplete="off">
                <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($_GET['redirect'] ?? ''); ?>">
                
                <div class="connexion-split-zone">
                    
                    <div class="connexion-inputs-col">
                        <div class="input-group-connexion">
                            <label for="pseudo">Nom d'équipe (Pseudo)</label>
                            <input type="text" id="pseudo" name="pseudo" class="input-connexion-moyen" required placeholder="Votre pseudo d'équipe">
                        </div>
                        
                        <div class="input-group-connexion">
                            <label for="password">Mot de passe</label>
                            <input type="password" id="password" name="password" class="input-connexion-grandV2" required placeholder="••••••••">
                        </div>
                    </div>

                    <div class="connexion-logo-col">
                        <img src="images/logo_red.png" alt="Logo Casino" class="logo-red-Form">
                    </div>

                </div>
                
                <a href="mdp_oublie.php" class="lien-mdp-oublie">Mot de passe oublié ?</a>                
                <button type="submit" class="btn-valider-connexion">Entrer au casino</button>
            </form>
        </div>

    </div>
</main>

<script src="js/script.js"></script>

<?php include_once("view/footer.php"); ?>