<?php require_once 'header.php'; ?>

<main>
    <div class="cadre-formulaire">
        <h2>Inscription d'une nouvelle équipe</h2>

        <?php if (!empty($message)): ?>
            <p class="error-message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form action="../controller/inscription_controller.php" method="POST">
            
            <label for="nom_equipe">Nom de l'équipe :</label>
            <input type="text" id="nom_equipe" name="nom_equipe" required>

            <label for="mot_de_passe">Mot de passe (8 caractères min.) :</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            
            <label for="nombre_participants">Nombre de participants (entre 8 et 10) :</label>
            <input type="number" id="nombre_participants" name="nombre_participants" min="8" max="10" required>

            <button type="submit">Créer l'équipe</button>
        </form>
        
        <p class="form-lien">Déjà une équipe ? <a href="/var/www/html/sae202_event/connexion.php">Connectez-vous ici</a>.</p>
    </div>
</main>

<?php require_once '/var/www/html/sae202_event/view/footer.php'; ?>
