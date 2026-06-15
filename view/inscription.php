<?php 
// view/inscription.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../view/header.php'; 

// Récupération des erreurs potentielles transmises par le contrôleur principal
$error_message = '';
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'missing_fields': $error_message = 'Veuillez remplir tous les champs.'; break;
        case 'invalid_email': $error_message = 'Adresse e-mail invalide.'; break;
        case 'password_too_short': $error_message = 'Le mot de passe doit contenir au moins 8 caractères.'; break;
        case 'password_mismatch': $error_message = 'Les mots de passe ne correspondent pas.'; break;
        case 'email_exists': $error_message = 'Cet e-mail est déjà associé à une équipe.'; break;
        case 'db_error': $error_message = 'Une erreur technique est survenue.'; break;
    }
}
?>

<main>
    <div class="cadre-formulaire">
        <h2>INSCRIPTION NOUVELLE ÉQUIPE</h2>

        <?php if (!empty($error_message)): ?>
            <p class="error-message" style="color: #e74c3c; font-weight: bold; margin-bottom: 15px;">
                ❌ <?php echo htmlspecialchars($error_message); ?>
            </p>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <p style="color: #2ecc71; font-weight: bold; margin-bottom: 15px;">
                Équipe enregistrée avec succès ! Vous pouvez maintenant vous connecter.
            </p>
        <?php endif; ?>

        <form action="controller/inscription_controller.php" method="POST">
            
            <label for="pseudo">Nom de l'équipe (Pseudo) :</label>
            <input type="text" id="pseudo" name="pseudo" required placeholder="Ex: Les As du Volant">

            <label for="email">E-mail du responsable :</label>
            <input type="email" id="email" name="email" required placeholder="responsable@mail.com">

            <label for="telephone">Téléphone du responsable :</label>
            <input type="tel" id="telephone" name="telephone" required placeholder="0600000000">

            <label for="mot_de_passe">Mot de passe d'accès :</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required placeholder="8 caractères min.">
            
            <label for="mot_de_passe2">Confirmez le mot de passe :</label>
            <input type="password" id="mot_de_passe2" name="mot_de_passe2" required placeholder="••••••••">

            <button type="submit">CRÉER L'ÉQUIPE</button>
        </form>
        
        <p class="form-lien" style="margin-top: 15px; text-align: center;">
            Déjà inscrit ? <a href="connexion.php">Connectez-vous ici</a>.
        </p>
    </div>
</main>

<?php require_once __DIR__ . '/../view/footer.php'; ?>