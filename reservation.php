<?php
session_start();
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

<main class="page-reservation">

    <h2>Réservation</h2>

    <?php if ($success): ?>

        <div class="message-succes cadre-ambiance">
            <p>Votre réservation a bien été enregistrée !<br>
            Vous recevrez une confirmation à l'adresse indiquée.</p>
            <a href="profil.php" class="btn-reserver" style="display:inline-block;margin-top:25px;">Voir mes réservations</a>
        </div>

    <?php else: ?>

        <?php if ($error): ?>
            <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <div class="conteneur-reservation">

            <div class="reservation-ambiance">
                <div class="cadre-ambiance">
                    <p class="storytelling">
                        Une nuit. Un casino clandestin.<br>
                        Huit convives autour d'une table qui ne savent pas encore ce qui les attend...
                    </p>
                    <p class="storytelling" style="margin-top:1.2rem;">
                        Réservez votre table, constituez votre groupe, choisissez votre niveau — et que la nuit commence.
                    </p>
                    <p class="slogan-accueil" style="margin-top:1.5rem;">
                        Alors, qui trouvera l'assassin… qui réussira à sortir vivant ?
                    </p>
                </div>
            </div>

            <div class="reservation-formulaire">
                <div class="cadre-formulaire-reservation">
                    <h3>Faites vos jeux</h3>

                    <form method="POST" action="reservation.php" class="form-reservation">

                        <div class="form-ligne-double">
                            <div class="form-groupe">
                                <label for="nom">Nom *</label>
                                <input type="text" id="nom" name="nom"
                                       value="<?php echo htmlspecialchars($_POST['nom'] ?? ''); ?>"
                                       placeholder="Votre nom" required>
                            </div>
                            <div class="form-groupe">
                                <label for="date">Date *</label>
                                <input type="date" id="date" name="date"
                                       value="<?php echo htmlspecialchars($_POST['date'] ?? ''); ?>"
                                       min="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                        </div>

                        <div class="form-groupe">
                            <label for="email">E-mail *</label>
                            <input type="email" id="email" name="email"
                                   value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                                   placeholder="votre@email.com" required>
                        </div>

                        <div class="form-groupe">
                            <label for="nom_groupe">Nom de groupe <span class="form-hint">(optionnel)</span></label>
                            <input type="text" id="nom_groupe" name="nom_groupe"
                                   value="<?php echo htmlspecialchars($_POST['nom_groupe'] ?? ''); ?>"
                                   placeholder="Nom de votre équipe">
                        </div>

                        <div class="form-groupe">
                            <label for="nb_joueurs">Nombre de participants * <span class="form-hint">(8 à 10)</span></label>
                            <input type="number" id="nb_joueurs" name="nb_joueurs"
                                   value="<?php echo htmlspecialchars($_POST['nb_joueurs'] ?? ''); ?>"
                                   min="8" max="10" placeholder="8 – 10" required>
                        </div>

                        <div class="form-groupe">
                            <label for="mode">Mode de jeu *</label>
                            <select id="mode" name="mode" required>
                                <option value="" disabled <?php echo empty($_POST['mode']) ? 'selected' : ''; ?>>
                                    -- Choisissez votre niveau --
                                </option>
                                <option value="facile"        <?php echo (($_POST['mode'] ?? '') === 'facile')        ? 'selected' : ''; ?>>Facile</option>
                                <option value="intermediaire" <?php echo (($_POST['mode'] ?? '') === 'intermediaire') ? 'selected' : ''; ?>>Intermédiaire</option>
                                <option value="hardcore"      <?php echo (($_POST['mode'] ?? '') === 'hardcore')      ? 'selected' : ''; ?>>Hardcore</option>
                            </select>
                        </div>

                        <button type="submit" class="btn-reserver">Réserver</button>

                    </form>
                </div>
            </div>

        </div>
    <?php endif; ?>

</main>

<?php include_once("view/footer.php"); ?>