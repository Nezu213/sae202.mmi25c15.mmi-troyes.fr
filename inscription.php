<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Inclusion directe de l'en-tête depuis la racine
include_once("view/header.php");

// --- Gestion des messages d'erreur et de succès ---
$error_message = '';
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'missing_fields': $error_message = 'Veuillez remplir tous les champs.'; break;
        case 'invalid_email': $error_message = 'Adresse e-mail invalide.'; break;
        case 'password_too_short': $error_message = 'Le mot de passe doit contenir au moins 8 caractères.'; break;
        case 'password_mismatch': $error_message = 'Les mots de passe ne correspondent pas.'; break;
        case 'email_exists': $error_message = 'Cet email est déjà utilisé.'; break;
        case 'db_error': $error_message = 'Une erreur est survenue. Veuillez réessayer.'; break;
    }
}
$success = isset($_GET['success']);
?>

<main class="page-inscription-unique">
    <div class="container-inscription">
        
        <h1 class="titre-inscription">INSCRIPTION</h1>

        <?php if ($success): ?>
            <div class="msg-success-box">
                ✨ Compte créé avec succès ! Vous pouvez maintenant vous connecter.
                <div style="margin-top: 15px;">
                    <a href="connexion.php" style="color: #ffffff; text-decoration: underline;">Se connecter</a>
                </div>
            </div>
        <?php else: ?>
            
            <h2 class="sous-titre-inscription">REJOINDRE LE CLUB</h2>

            <?php if (!empty($error_message)): ?>
                <div class="msg-error-box">
                    ❌ <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>

            <div class="wrapper-cadre-inscription">
                <form action="controller/inscription_controller.php" method="POST" class="form-inscription" autocomplete="off">
                    
                    <div class="row-inputs-double">
                        <div class="input-group-inscription">
                            <label for="pseudo">Pseudo *</label>
                            <input type="text" id="pseudo" name="pseudo" class="input-inscription-grand" required placeholder="Votre pseudo" value="<?php echo htmlspecialchars($_POST['pseudo'] ?? ''); ?>">
                        </div>
                        <div class="input-group-inscription">
                            <label for="email">E-mail *</label>
                            <input type="email" id="email" name="email" class="input-inscription-grand" required placeholder="votre@email.com" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="row-inputs-double">
                        <div class="input-group-inscription">
                            <label for="mot_de_passe">Mot de passe * <span class="form-hint">(min. 8 caractères)</span></label>
                            <input type="password" id="mot_de_passe" name="mot_de_passe" class="input-inscription-grand" required placeholder="••••••••">
                        </div>
                        <div class="input-group-inscription">
                            <label for="mot_de_passe2">Confirmer le mot de passe *</label>
                            <input type="password" id="mot_de_passe2" name="mot_de_passe2" class="input-inscription-grand" required placeholder="••••••••">
                        </div>
                    </div>

                    <div class="row-inputs-double">
                        <div class="input-group-inscription">
                            <label for="telephone">Téléphone *</label>
                            <input type="tel" id="telephone" name="telephone" class="input-inscription-grand" required placeholder="06 00 00 00 00" value="<?php echo htmlspecialchars($_POST['telephone'] ?? ''); ?>">
                        </div>
                    </div>

                    <button type="submit" class="btn-valider-inscription">Rejoindre le Club</button>
                </form>
            </div>

            <p class="form-lien-inscription" style="text-align: center; margin-top: 20px;">
                Déjà un compte ? <a href="connexion.php" style="color: #f1c40f; text-decoration: underline;">Se connecter</a>
            </p>
        <?php endif; ?>

    </div>
</main>

<script src="js/script.js"></script>

<?php include_once("view/footer.php"); ?>