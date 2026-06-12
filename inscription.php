<?php
include_once("view/header.php");

// --- Gestion des messages d'erreur et de succès ---
$error_message = '';
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'missing_fields':
            $error_message = 'Veuillez remplir tous les champs.';
            break;
        case 'invalid_email':
            $error_message = 'Adresse e-mail invalide.';
            break;
        case 'password_too_short':
            $error_message = 'Le mot de passe doit contenir au moins 8 caractères.';
            break;
        case 'password_mismatch':
            $error_message = 'Les mots de passe ne correspondent pas.';
            break;
        case 'email_exists':
            $error_message = 'Cet email est déjà utilisé.';
            break;
        case 'db_error':
            $error_message = 'Une erreur est survenue. Veuillez réessayer.';
            break;
    }
}

$success = isset($_GET['success']);
?>

<main class="page-connexion">
    <h2>Inscription</h2>

    <?php if ($success): ?>
        <div class="cadre-formulaire" style="text-align:center;">
            <p style="color:#c8e6c9; font-size:1.1rem; margin-bottom:20px;">
                ✅ Compte créé avec succès ! Vous pouvez maintenant vous connecter.
            </p>
            <a href="connexion.php" class="btn-reserver" style="display:inline-block;">Se connecter</a>
        </div>
    <?php else: ?>
        <div class="cadre-formulaire">
            <h3>Rejoindre le Club</h3>

            <?php if ($error_message): ?>
                <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>

            <form method="POST" action="controller/inscription_controller.php">
                <div class="form-groupe">
                    <label for="pseudo">Pseudo *</label>
                    <input type="text" id="pseudo" name="pseudo" placeholder="Votre pseudo" required>
                </div>

                <div class="form-groupe">
                    <label for="email">E-mail *</label>
                    <input type="email" id="email" name="email" placeholder="votre@email.com" required>
                </div>

                <div class="form-groupe">
                    <label for="telephone">Téléphone *</label>
                    <input type="tel" id="telephone" name="telephone" placeholder="06 00 00 00 00" required>
                </div>

                <div class="form-groupe">
                    <label for="mot_de_passe">Mot de passe * <span class="form-hint">(min. 8 caractères)</span></label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="••••••••" required>
                </div>

                <div class="form-groupe">
                    <label for="mot_de_passe2">Confirmer le mot de passe *</label>
                    <input type="password" id="mot_de_passe2" name="mot_de_passe2" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-reserver">Rejoindre le Club</button>
            </form>

            <p class="form-lien">
                Déjà un compte ? <a href="connexion.php">Se connecter</a>
            </p>
        </div>
    <?php endif; ?>
</main>

<?php include_once("view/footer.php"); ?>