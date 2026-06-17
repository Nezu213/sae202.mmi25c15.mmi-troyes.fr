<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php?redirect=profil.php');
    exit;
}

require_once 'model/reservation_model.php';
include_once("view/header.php");

$mes_reservations = get_reservations_by_user($_SESSION['user_id']);

require_once 'view/bdd.php';
$stmt = $link->prepare("SELECT user_telephone, user_email FROM user WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user_info = $stmt->fetch();

$tel_actuel = $user_info['user_telephone'] ?? '';
$email_actuel = $user_info['user_email'] ?? $_SESSION['user_email'];
?>

<main class="page-profil-unique">
    <div class="container-profil">
        
        <h1 class="titre-espace">
            <span class="icon-avatar"><img src="images/profil.png" alt="Avatar"></span>
            MON ESPACE
        </h1>

        <?php if (isset($_GET['success']) && $_GET['success'] === 'profil_updated'): ?>
            <div class="msg-success-box">
                <span class="icon-success">✨</span> Vos coordonnées ont été mises à jour avec succès !
            </div>
        <?php endif; ?>

<section class="section-infos">
            <h2 class="titre-section">MES INFORMATIONS</h2>
            
            <div class="wrapper-cadre-epines">
                <form action="controller/profil_controller.php" method="POST" class="form-profil" autocomplete="off">
                    
                    <div class="row-inputs">
                        <div class="input-group">
                            <label for="pseudo">Nom</label>
                            <input type="text" id="pseudo" name="pseudo" value="<?php echo htmlspecialchars($_SESSION['pseudo']); ?>" class="input-special-petit" required>
                        </div>
                        <div class="input-group">
                            <label for="telephone">Téléphone de contact</label>
                            <input type="text" id="telephone" name="telephone" value="<?php echo htmlspecialchars($tel_actuel); ?>" class="input-special-petit" required>
                        </div>
                    </div>
                    
                    <div class="input-group full-width">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email_actuel); ?>" class="input-special-grand" required>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; gap: 15px;">
                        <button type="submit" name="update_profile" class="btn-modifier-profil">Modifier</button>
                        
                        <button type="submit" name="delete_account" class="btn-supprimer-compte" 
                                style="background: #c0392b; color: #fff; border: 1px solid #c0392b; padding: 10px 15px; font-weight: bold; cursor: pointer; transition: all 0.3s;"
                                onclick="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer définitivement votre compte équipe ? Cette action annulera également vos réservations.');">
                            Supprimer le compte
                        </button>
                    </div>
                </form>
            </div>
        </section>

        
        <section class="section-avis">
            <h2 class="titre-section">LAISSER UN AVIS</h2>
            
            <div class="wrapper-cadre-avis">
                <div class="content-avis-interne">
                    <label>Avis :</label>
                    
                    <div class="rating-spades">
                        <span class="spade gold"></span>
                        <span class="spade gold"></span>
                        <span class="spade gold"></span>
                        <span class="spade gold"></span>
                        <span class="spade dark"></span>
                    </div>
                    
                    <div class="scrollable-historique">
                        <?php if (empty($mes_reservations)): ?>
                            <p class="no-reservations">Vous n'avez pas encore planifié de session d'escape game au casino.</p>
                        <?php else: ?>
                            <?php foreach ($mes_reservations as $r): ?>
                                <div class="reservation-card">
                                    <p><strong>Groupe :</strong> <?php echo htmlspecialchars($r['nom_groupe'] ?? 'Non défini'); ?></p>
                                    <p><strong>Date :</strong> <?php echo date('d/m/Y', strtotime($r['date_reservations'])); ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

    </div>
</main>

<script src="js/script.js"></script>

<?php include_once("view/footer.php"); ?>