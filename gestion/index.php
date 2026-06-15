<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Authentification HTTP exigee par le cahier des charges (Invite de saisie du navigateur)
$admin_attendu = 'admin'; 
$mdp_attendu = 'URCA_mmi2026'; 

if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) || 
    $_SERVER['PHP_AUTH_USER'] !== $admin_attendu || $_SERVER['PHP_AUTH_PW'] !== $mdp_attendu) {
    
    header('WWW-Authenticate: Basic realm="Acces Reserve au Croupier"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Acces refuse. Vous devez saisir les identifiants administrateur.';
    exit;
}

// Definition des variables de session suite a la validation de l'invite
$_SESSION['role'] = 'admin';
$_SESSION['pseudo'] = 'Croupier Principal';

// On modifie le chemin d'inclusion de PHP pour corriger les inclusions internes du header
set_include_path(get_include_path() . PATH_SEPARATOR . '../' . PATH_SEPARATOR . './');

// Ouverture de la base de données via le bon chemin absolu
require_once __DIR__ . '/../view/bdd.php';

// Chargement des modeles
require_once '../model/admin_model.php'; 
require_once '../model/reservation_model.php';
require_once '../model/avis_model.php';

// Chargement des donnees avant l'affichage HTML
$stats = get_stats_dashboard();
$equipes_inscrites = get_toutes_reservations_admin();
$avis_a_valider = get_avis_a_valider(); 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <base href="../">
    <style>
        #preloader, .preloader-logo, .preloader-nav {
            display: none !important;
            opacity: 0 !important;
            visibility: hidden !important;
            height: 0 !important;
            width: 0 !important;
            overflow: hidden !important;
        }
    </style>
</head>
<body style="background: #111;">

<?php include_once("view/header.php"); ?>

<main class="admin-dashboard" style="padding: 20px; max-width: 1200px; margin: 0 auto; background: #111; color: #fff; min-height: 100vh;">
    <h2>Tableau de Bord Administrateur - Sessions Reservees</h2>
    <p>Bienvenue (Controle total du Casino)</p>

    <div style="margin: 20px 0;">
        <a href="controller/export.php" style="background: #f1c40f; color: #000; padding: 12px 20px; font-weight: bold; text-decoration: none; display: inline-block; border-radius: 4px; border: 1px solid #f1c40f; transition: all 0.3s;">
            EXPORTER LES RESERVATIONS (CSV)
        </a>
    </div>

    <div id="alert-container">
        <?php if (isset($_GET['success']) && $_GET['success'] === 'score_updated'): ?>
            <div class="auto-flash" style="background: #2ecc71; color: #fff; padding: 12px; margin-bottom: 20px; font-weight: bold;">
                Le score a ete mis a jour avec succes !
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success']) && $_GET['success'] === 'reservation_deleted'): ?>
            <div class="auto-flash" style="background: rgba(231, 76, 60, 0.2); color: #e74c3c; border: 1px solid #e74c3c; padding: 12px; margin-bottom: 20px; font-weight: bold;">
                La reservation et l'equipe associee ont ete supprimees avec succes.
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success']) && $_GET['success'] === 'avis_approved'): ?>
            <div class="auto-flash" style="background: #2ecc71; color: #fff; padding: 12px; margin-bottom: 20px; font-weight: bold;">
                L'avis a ete approuve et publie avec succes.
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success']) && $_GET['success'] === 'avis_deleted'): ?>
            <div class="auto-flash" style="background: rgba(231, 76, 60, 0.2); color: #e74c3c; border: 1px solid #e74c3c; padding: 12px; margin-bottom: 20px; font-weight: bold;">
                L'avis a ete supprime avec succes.
            </div>
        <?php endif; ?>
    </div>

    <section class="admin-section" style="margin-bottom: 30px; background: #222; padding: 15px;">
        <h3>Statistiques Cles</h3>
        <div style="display: flex; gap: 20px;">
            <div style="background: #333; padding: 15px; flex: 1; text-align: center;">
                <div style="font-size: 24px; font-weight: bold; color: #f1c40f;"><?php echo (int)($stats['total_reservations'] ?? 0); ?></div>
                <div>Reservations totales</div>
            </div>
            <div style="background: #333; padding: 15px; flex: 1; text-align: center;">
                <div style="font-size: 24px; font-weight: bold; color: #f1c40f;"><?php echo (int)($stats['total_joueurs'] ?? 0); ?></div>
                <div>Joueurs attendus</div>
            </div>
            <div style="background: #333; padding: 15px; flex: 1; text-align: center;">
                <div style="font-size: 24px; font-weight: bold; color: #f1c40f;"><?php echo (int)($stats['avis_en_attente'] ?? 0); ?></div>
                <div>Avis en attente</div>
            </div>
        </div>
    </section>

    <section class="admin-section" style="margin-bottom: 40px; background: #222; padding: 15px;">
        <h3>1. Moderation des Avis en Attente</h3>
        <?php if (empty($avis_a_valider)): ?>
            <p>Aucun avis en attente de validation.</p>
        <?php else: ?>
            <table border="1" style="width:100%; border-collapse: collapse; text-align: left; color: #fff; border-color: #444;">
                <thead>
                    <tr style="background-color: #333;">
                        <th style="padding: 10px;">Pseudo</th>
                        <th style="padding: 10px;">Commentaire</th>
                        <th style="padding: 10px;">Note</th>
                        <th style="padding: 10px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($avis_a_valider as $avis): ?>
                        <tr>
                            <td style="padding: 10px;"><?php echo htmlspecialchars($avis['user_pseudo'] ?? 'Anonyme'); ?></td>
                            <td style="padding: 10px;"><?php echo nl2br(htmlspecialchars($avis['commentaire'] ?? '')); ?></td>
                            <td style="padding: 10px;"><?php echo (int)($avis['note'] ?? 0); ?> / 5</td>
                            <td style="padding: 10px;">
                                <a href="controller/admin_controller.php?action=approuver_avis&id=<?php echo $avis['id_avis']; ?>" style="color: #2ecc71; font-weight: bold; margin-right: 10px; text-decoration: none;">Accepter</a>
                                <a href="controller/admin_controller.php?action=supprimer_avis&id=<?php echo $avis['id_avis']; ?>" style="color: #e74c3c; font-weight: bold; text-decoration: none;" onclick="return confirm('Refuser cet avis ?');">Refuser</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>

    <section class="admin-section" style="background: #222; padding: 15px;">
        <h3>2. Equipes Inscrites & Gestion des Scores</h3>
        <table border="1" style="width:100%; border-collapse: collapse; text-align: left; color: #fff; border-color: #444;">
            <thead>
                <tr style="background-color: #333;">
                    <th style="padding: 10px;">Nom du Groupe</th>
                    <th style="padding: 10px;">Responsable</th>
                    <th style="padding: 10px;">Date Reservation</th>
                    <th style="padding: 10px; text-align: center;">Joueurs</th>
                    <th style="padding: 10px; text-align: center;">Modifier le Score</th>
                    <th style="padding: 10px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($equipes_inscrites)): ?>
                    <?php foreach ($equipes_inscrites as $equipe): ?>
                        <tr>
                            <td style="padding: 10px; font-weight: bold;">
                                <?php echo htmlspecialchars($equipe['nom_groupe'] ?? 'Sans nom'); ?>
                            </td>
                            <td style="padding: 10px; color: #aaa;">
                                <?php echo htmlspecialchars($equipe['user_email_compte'] ?? $equipe['user_pseudo'] ?? 'N/A'); ?>
                            </td>
                            <td style="padding: 10px;">
                                <?php echo isset($equipe['date_reservations']) ? date('d/m/Y', strtotime($equipe['date_reservations'])) : 'N/A'; ?>
                            </td>
                            <td style="padding: 10px; text-align: center; font-weight: bold; color: #f1c40f;">
                                <?php echo (int)($equipe['nb_joueurs'] ?? 0); ?>
                            </td>
                            <td style="padding: 10px; text-align: center;">
                                <form action="controller/admin_controller.php?action=modifier_score" method="POST" style="display: inline-flex; gap: 5px; justify-content: center; align-items: center; width: 100%;">
                                    <input type="hidden" name="id_session" value="<?php echo $equipe['id_reservations']; ?>">
                                    <input type="number" name="nouveau_score" value="<?php echo (int)($equipe['score'] ?? 0); ?>" style="width: 60px; background: #333; color: #fff; border: 1px solid #555; padding: 5px; text-align: center;" required>
                                    <button type="submit" style="cursor: pointer; background: #f1c40f; color: #000; border: none; padding: 5px 10px; font-weight: bold;">METTRE A JOUR</button>
                                </form>
                            </td>
                            <td style="padding: 10px; text-align: center;">
                                <a href="controller/admin_controller.php?action=supprimer_reservation&id=<?php echo $equipe['id_reservations']; ?>" 
                                   onclick="return confirm('Voulez-vous vraiment supprimer definitivement cette inscription d\'equipe ?');" 
                                   style="color: #fff; background: #c0392b; padding: 5px 10px; font-weight: bold; text-decoration: none; display: inline-block; border-radius: 3px; font-size: 13px;">
                                    Supprimer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="padding: 10px; text-align: center; font-style: italic; color: #888;">Aucune equipe inscrite pour le moment.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

<?php include_once("view/footer.php"); ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const alerts = document.querySelectorAll('.auto-flash');
    alerts.forEach(function(alert) {
        alert.style.transition = "opacity 0.6s ease, max-height 0.6s ease, padding 0.6s ease, margin 0.6s ease";
        alert.style.styleFloat = "left";
        alert.style.overflow = "hidden";
        alert.style.maxHeight = "100px";

        setTimeout(function() {
            alert.style.opacity = "0";
            alert.style.maxHeight = "0px";
            alert.style.paddingTop = "0px";
            alert.style.paddingBottom = "0px";
            alert.style.marginTop = "0px";
            alert.style.marginBottom = "0px";
            setTimeout(() => alert.remove(), 600);
        }, 4000);
    });
});
</script>

</body>
</html>