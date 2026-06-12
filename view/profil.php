<?php 
include_once("view/header.php"); 

// Sécurité : si pas connecté, on dégage vers l'accueil
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}
?>

<main>
    <link rel="stylesheet" href="css/style.css">
    <h2>Espace de l'équipe : <?php echo htmlspecialchars($_SESSION['nom_equipe']); ?></h2> [cite: 55]

    <section class="mon-score">
        <h3>Votre Score de Session</h3>
        <?php if ($score): ?> [cite: 52]
            <p>Temps de sortie : <b><?php echo $score['temps']; ?> minutes</b></p>
            <p>Indices utilisés : <?php echo $score['indices']; ?></p>
        <?php else: ?>
            <p>Aucun score enregistré pour le moment. Le croupier doit valider votre partie.</p>
        <?php endif; ?>
    </section>

    <section class="deposer-avis">
        <h3>Laisser un Avis sur l'Événement</h3> [cite: 9, 52]
        <?php if (!empty($msg_avis)): echo $msg_avis; endif; ?> [cite: 54]
        
        <form action="profil.php" method="POST">
            <label for="commentaire">Votre retour d'expérience :</label>
            <textarea id="commentaire" name="commentaire" required></textarea>
            <button type="submit" name="action_avis">PUBLIER MON AVIS</button>
        </form>
    </section>
</main>

<?php include_once("view/footer.php"); ?>
