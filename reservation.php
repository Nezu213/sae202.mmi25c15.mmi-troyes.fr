<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'model/reservation_model.php';
include_once("view/header.php");

// Redirection si non connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php?redirect=reservation.php');
    exit;
}

$success = false;
$error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom        = trim($_POST['nom'] ?? '');
    $date       = trim($_POST['date'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $nom_groupe = trim($_POST['nom_groupe'] ?? '');
    $nb_joueurs = intval($_POST['nb_joueurs'] ?? 0);
    $mode       = trim($_POST['mode'] ?? '');

    if (!$nom || !$date || !$email || !$nb_joueurs || !$mode) {
        $error = 'Veuillez remplir tous les champs obligatoires.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Adresse e-mail invalide.';
    } elseif ($nb_joueurs < 8 || $nb_joueurs > 10) {
        $error = 'Le nombre de participants doit être entre 8 et 10.';
    } elseif (strtotime($date) < strtotime('today')) {
        $error = 'La date choisie est déjà passée.';
    } else {
        $ok = creer_reservation($nom, $date, $email, $nom_groupe, $nb_joueurs, $mode, $_SESSION['user_id']);
        if ($ok) {
            $success = true;
        } else {
            $error = 'Une erreur est survenue. Veuillez réessayer.';
        }
    }
}
?>

<main class="page-reservation-unique">
    <div class="container-reservation">
        
        <h1 class="titre-reservation">RÉSERVATION</h1>

        <?php if ($success): ?>
            <div class="message-succes">
                <p class="success-title">✨ SÉLECTION ENREGISTRÉE</p>
                <p class="success-text">Votre session d'escape game clandestin est réservée.<br>Un e-mail de confirmation vient d'être envoyé au responsable.</p>
                <a href="profil.php" class="btn-profil-ret">VOIR MON PROFIL</a>
            </div>
        <?php else: ?>

            <?php if ($error): ?>
                <div class="msg-error-box">
                    ❌ <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <div class="wrapper-cadre-reservation-epines">
                <form method="POST" action="reservation.php" autocomplete="off">
                    
                    <div class="form-ligne-double">
                        <div class="input-group-reservation">
                            <label for="nom">Nom</label>
                            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($_POST['nom'] ?? ''); ?>" class="input-moyen" required>
                        </div>
                        <div class="input-group-reservation">
                            <label for="date">Date</label>
                            <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($_POST['date'] ?? ''); ?>" min="<?php echo date('Y-m-d'); ?>" class="input-moyen" required>
                        </div>
                    </div>

                    <div class="input-group-reservation full-width">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" class="input-grand" required>
                    </div>

                    <div class="input-group-reservation full-width">
                        <label for="nom_groupe">Nom de groupe</label>
                        <input type="text" id="nom_groupe" name="nom_groupe" value="<?php echo htmlspecialchars($_POST['nom_groupe'] ?? ''); ?>" class="input-grand">
                    </div>

                    <div class="input-group-reservation full-width">
                        <label for="nb_joueurs">Nombre de participants</label>
                        <input type="number" id="nb_joueurs" name="nb_joueurs" value="<?php echo htmlspecialchars($_POST['nb_joueurs'] ?? ''); ?>" min="8" max="10" class="input-grand" required>
                    </div>

                    <div class="input-group-reservation full-width">
                        <label for="mode">Mode de jeu</label>
                        <div class="select-wrapper">
                            <select id="mode" name="mode" class="select-grand" required>
                                <option value="" disabled <?php echo empty($_POST['mode']) ? 'selected' : ''; ?>>-- Choisissez votre niveau --</option>
                                <option value="facile"        <?php echo (($_POST['mode'] ?? '') === 'facile')        ? 'selected' : ''; ?>>Facile</option>
                                <option value="intermediaire" <?php echo (($_POST['mode'] ?? '') === 'intermediaire') ? 'selected' : ''; ?>>Intermédiaire</option>
                                <option value="hardcore"      <?php echo (($_POST['mode'] ?? '') === 'hardcore')      ? 'selected' : ''; ?>>Hardcore</option>
                            </select>
                            <span class="select-arrow">▼</span>
                        </div>
                    </div>

                    <div class="submit-block">
                        <button type="submit" class="btn-reserver-casino">RÉSERVER</button>
                    </div>

                </form>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php include_once("view/footer.php"); ?>