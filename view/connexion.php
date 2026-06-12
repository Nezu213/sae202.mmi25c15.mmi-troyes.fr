<?php
include_once("view/header.php");
?>

<main>
    <div class="cadre-formulaire">
        <h2>CONNEXION ÉQUIPE</h2>
        <?php if (isset($_GET['error'])): ?>
            <p class="error-message">L'e-mail fourni n'a pas été trouvé.</p>
        <?php endif; ?>

        <form action="/sae202_event/controller/connexion_controller.php" method="POST">
            <label for="email">E-mail du responsable :</label>
            <input type="email" id="email" name="email" required>

            <button type="submit">ENTRER AU CASINO</button>
        </form>
    </div>
</main>

<?php include_once("view/footer.php"); ?>