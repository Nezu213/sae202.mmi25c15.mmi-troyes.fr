<?php


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'model/admin_model.php'; 
require_once 'model/reservation_model.php';
require_once 'model/avis_model.php';

// BARRIÈRE DE SÉCURITÉ
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: connexion.php?error=unauthorized');
    exit();
}

include_once("view/header.php");

$stats = get_stats_dashboard();
$equipes_inscrites = get_toutes_reservations_admin();
$avis_a_valider = get_avis_a_valider(); 
?>

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

<main class="admin-dashboard" style="padding: 20px; max-width: 1200px; margin: 0 auto; background: #111; color: #fff; min-height: 100vh;">
    <h2>Tableau de Bord Administrateur — Sessions Réservées</h2>
    <p>Bienvenue, <?php echo htmlspecialchars($_SESSION['pseudo']); ?> (Contrôle total du Casino)</p>

    <?php if (isset($_GET['success']) && $_GET['success'] === 'score_updated'): ?>
        <div style="background: #2ecc71; color: #fff; padding: 10px; margin-bottom: 20px; font-weight: bold;">
            Le score a été mis à jour avec succès !
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['success']) && $_GET['success'] === 'reservation_deleted'): ?>
        <div style="background: rgba(231, 76, 60, 0.2); color: #e74c3c; border: 1px solid #e74c3c; padding: 10px; margin-bottom: 20px; font-weight: bold;">
            La réservation et l'équipe associée ont été supprimées avec succès.
        </div>
    <?php endif; ?>

    <section class="admin-section" style="margin-bottom: 30px; background: #222; padding: 15px;">
        <h3>Statistiques Clés</h3>
        <div style="display: flex; gap: 20px;">
            <div style="background: #333; padding: 15px; flex: 1; text-align: center;">
                <div style="font-size: 24px; font-weight: bold; color: #f1c40f;"><?php echo (int)$stats['total_reservations']; ?></div>
                <div>Réservations totales</div>
            </div>
            <div style="background: #333; padding: 15px; flex: 1; text-align: center;">
                <div style="font-size: 24px; font-weight: bold; color: #f1c40f;"><?php echo (int)$stats['total_joueurs']; ?></div>
                <div>Joueurs attendus</div>
            </div>
            <div style="background: #333; padding: 15px; flex: 1; text-align: center;">
                <div style="font-size: 24px; font-weight: bold; color: #f1c40f;"><?php echo (int)$stats['avis_en_attente']; ?></div>
                <div>Avis en attente</div>
            </div>
        </div>
    </section>

    <section class="admin-section" style="margin-bottom: 40px; background: #222; padding: 15px;">
        <h3>1. Modération des Avis en Attente</h3>
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
        <h3>2. Équipes Inscrites & Gestion des Scores</h3>
        <table border="1" style="width:100%; border-collapse: collapse; text-align: left; color: #fff; border-color: #444;">
            <thead>
                <tr style="background-color: #333;">
                    <th style="padding: 10px;">Nom du Groupe</th>
                    <th style="padding: 10px;">Responsable</th>
                    <th style="padding: 10px;">Date Réservation</th>
                    <th style="padding: 10px; text-align: center;">Joueurs</th>
                    <th style="padding: 10px; text-align: center;">Modifier le Score</th>
                    <th style="padding: 10px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($equipes_inscrites)): ?>
                    <?php foreach ($equipes_inscrites as $equipe): ?>
                        <tr>
                            <td style="padding: 10px; font-weight: bold;"><?php echo htmlspecialchars($equipe['nom_groupe'] ?? 'Sans nom'); ?></td>
                            <td style="padding: 10px; color: #aaa;"><?php echo htmlspecialchars($equipe['user_email_compte'] ?? $equipe['user_pseudo'] ?? 'N/A'); ?></td>
                            <td style="padding: 10px;"><?php echo isset($equipe['date_reservations']) ? date('d/m/Y', strtotime($equipe['date_reservations'])) : 'N/A'; ?></td>
                            <td style="padding: 10px; text-align: center; font-weight: bold; color: #f1c40f;"><?php echo (int)($equipe['nb_joueurs'] ?? 0); ?></td>
                            <td style="padding: 10px; text-align: center;">
                                <form action="controller/admin_controller.php?action=modifier_score" method="POST" style="display: inline-flex; gap: 5px; justify-content: center; align-items: center; width: 100%;">
                                    <input type="hidden" name="id_session" value="<?php echo $equipe['id_reservations']; ?>">
                                    <input type="number" name="nouveau_score" value="<?php echo (int)($equipe['score'] ?? 0); ?>" style="width: 60px; background: #333; color: #fff; border: 1px solid #555; padding: 5px; text-align: center;" required>
                                    <button type="submit" style="cursor: pointer; background: #f1c40f; color: #000; border: none; padding: 5px 10px; font-weight: bold;">METTRE À JOUR</button>
                                </form>
                            </td>
                            <td style="padding: 10px; text-align: center;">
                                <a href="controller/admin_controller.php?action=supprimer_reservation&id=<?php echo $equipe['id_reservations']; ?>" 
                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement cette inscription d\'équipe ?');" 
                                   style="color: #fff; background: #c0392b; padding: 5px 10px; font-weight: bold; text-decoration: none; display: inline-block; border-radius: 3px; font-size: 13px;">
                                    Supprimer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="padding: 10px; text-align: center; font-style: italic; color: #888;">Aucune équipe inscrite pour le moment.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

<?php include_once("view/footer.php"); ?>