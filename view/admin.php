<?php
require_once '../view/header.php';
// Droits d'accès admin
require_once '../controller/admin_controller.php';
?>

<main>
    <section class="admin-dashboard">
        <h2>Tableau de Bord Administrateur</h2>

        <div class="admin-section">
            <h3>Bienvenue, <?php echo htmlspecialchars($_SESSION['nom_equipe']); ?> !</h3>
            <p>Ceci est votre espace d'administration. D'ici, vous pourrez gérer le contenu du site.</p>
        </div>

        <div class="admin-section">
            <h4>Avis en attente de validation</h4>
            <div class="liste-avis">
                <p>Aucun avis à valider pour le moment.</p>
            </div>
        </div>

        <div class="admin-section">
            <h4>Gestion des équipes</h4>
            <div class="liste-equipes">
                <p>La fonctionnalité de gestion des équipes sera bientôt disponible.</p>
            </div>
        </div>

    </section>
</main>

<?php
require_once '../view/footer.php';
?>
