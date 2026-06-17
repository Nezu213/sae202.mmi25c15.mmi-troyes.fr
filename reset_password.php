<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'view/bdd.php';
include_once("view/header.php");

$token_valide = false;
$token = $_GET['token'] ?? '';

if (!empty($token)) {
    // On vérifie si le token existe et n'est pas expiré
    $stmt = $link->prepare("SELECT user_id FROM user WHERE user_reset_token = ? AND user_reset_expires > NOW()");
    $stmt->execute([$token]);
    $user = $stmt->fetch();
    
    if ($user) {
        $token_valide = true;
    }
}
?>

<main class="page-connexion-unique">
    <div class="container-connexion">
        <h1 class="titre-connexion">NOUVEAU MOT DE PASSE</h1>

        <?php if (!$token_valide): ?>
            <div class="msg-error-box">
                ❌ Ce lien de récupération est invalide ou a expiré. Veuillez refaire une demande.
            </div>
            <div style="margin-top:20px;"><a href="mdp_oublie.php" style="color:#ecd499; font-family:'Georgia'; text-decoration:none;">Refaire une demande</a></div>
        <?php else: ?>
            
            <div class="wrapper-cadre-connexion">
                <form action="controller/reset_password_controller.php" method="POST" class="form-connexion" autocomplete="off">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                    
                    <div class="input-group-connexion">
                        <label for="password">Nouveau mot de passe</label>
                        <input type="password" id="password" name="password" class="input-connexion-moyen" required>
                    </div>

                    <div class="input-group-connexion">
                        <label for="confirm_password">Confirmer le mot de passe</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="input-connexion-grandV2" required>
                    </div>

                    <button type="submit" class="btn-valider-connexion">Mettre à jour</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include_once("view/footer.php"); ?>