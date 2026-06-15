<?php
// profil.php (à la racine)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Sécurité : si pas connecté, redirection immédiate
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php?redirect=profil.php');
    exit;
}

require_once 'model/reservation_model.php';
include_once("view/header.php");

// Récupération des réservations via ton modèle
$mes_reservations = get_reservations_by_user($_SESSION['user_id']);

// Extraction des données de contact pour pré-remplir le formulaire
require_once 'view/bdd.php';
$stmt = $link->prepare("SELECT user_telephone, user_email FROM user WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user_info = $stmt->fetch();

$tel_actuel = $user_info['user_telephone'] ?? '';
$email_actuel = $user_info['user_email'] ?? $_SESSION['user_email'];
?>

<main class="page-profil" style="max-width: 1000px; margin: 40px auto; padding: 20px; color: #fff;">
    
    <h2>Mon Espace Équipe</h2>

    <div class="profil-header" style="background: rgba(255,255,255,0.05); padding: 20px; margin-bottom: 25px; border: 1px solid #333; display: flex; align-items: center; gap: 20px;">
        <div style="background: #f1c40f; color: #000; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: bold;">
            <?php echo strtoupper(substr($_SESSION['pseudo'], 0, 1)); ?>
        </div>
        <div>
            <h3>Bienvenue, <?php echo htmlspecialchars($_SESSION['pseudo']); ?></h3>
            <p style="color: #aaa; font-size: 0.9rem;">Consultez vos scores et gérez vos accès de sécurité</p>
        </div>
    </div>

    <?php if (isset($_GET['success']) && $_GET['success'] === 'profil_updated'): ?>
        <p style="background: #2ecc71; color: #fff; padding: 12px; font-weight: bold; margin-bottom: 20px;">Vos coordonnées ont été mises à jour avec succès !</p>
    <?php endif; ?>

    <section style="background: #161616; padding: 25px; border: 1px solid #444; margin-bottom: 30px;">
        <h3 style="color: #f1c40f;">Modifier les informations de l'équipe</h3>
        <div style="height: 2px; background: #f1c40f; width: 60px; margin: 10px 0 20px 0;"></div>
        
        <form action="controller/profil_controller.php" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
            <div>
                <label style="display: block; margin-bottom: 5px;">Nom de l'équipe (Pseudo d'affichage) :</label>
                <input type="text" name="pseudo" value="<?php echo htmlspecialchars($_SESSION['pseudo']); ?>" style="width: 100%; padding: 10px; background: #222; color: #fff; border: 1px solid #555;" required>
            </div>
            <div>
                <label style="display: block; margin-bottom: 5px;">E-mail du capitaine / responsable :</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($email_actuel); ?>" style="width: 100%; padding: 10px; background: #222; color: #fff; border: 1px solid #555;" required>
            </div>
            <div>
                <label style="display: block; margin-bottom: 5px;">Numéro de téléphone de contact :</label>
                <input type="tel" name="telephone" value="<?php echo htmlspecialchars($tel_actuel); ?>" style="width: 100%; padding: 10px; background: #222; color: #fff; border: 1px solid #555;" required>
            </div>
            <button type="submit" class="btn-reserver" style="background: #f1c40f; color: #000; font-weight: bold; padding: 12px; border: none; cursor: pointer; max-width: 250px;">METTRE À JOUR</button>
        </form>
    </section>

    <section style="background: #161616; padding: 25px; border: 1px solid #444;">
        <h3 style="color: #f1c40f;">Historique de vos réservations & Scores</h3>
        <div style="height: 2px; background: #f1c40f; width: 60px; margin: 10px 0 20px 0;"></div>

        <?php if (empty($mes_reservations)): ?>
            <p style="font-style: italic; color: #888;">Vous n'avez pas encore planifié de session d'escape game au casino.</p>
        <?php else: ?>
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <?php foreach ($mes_reservations as $r): ?>
                    <div style="background: #222; padding: 20px; border-left: 4px solid #f1c40f; border-radius: 0 4px 4px 0;">
                        <p><strong>Groupe :</strong> <?php echo htmlspecialchars($r['nom_groupe'] ?? 'Non défini'); ?> (<?php echo (int)$r['nb_joueurs']; ?> joueurs)</p>
                        <p><strong>Date programmée :</strong> <?php echo date('d/m/Y', strtotime($r['date_reservations'])); ?> (Mode : <?php echo htmlspecialchars($r['mode_jeu']); ?>)</p>
                        <p><strong>Statut :</strong> <span style="text-transform: uppercase; font-size: 0.85rem; padding: 2px 6px; background: #444; color: #f1c40f;"><?php echo htmlspecialchars($r['status_paiement_reservations']); ?></span></p>
                        
                        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #333;">
                            <?php if (isset($r['score']) && $r['score'] > 0): ?>
                                <p style="color: #f1c40f; font-size: 1.1rem; font-weight: bold; margin-bottom: 10px;">
                                    🏆 Score validé : <?php echo (int)$r['score']; ?> énigmes résolues !
                                </p>
                                
                                <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                                    <span style="font-size: 0.85rem; color: #aaa;">Partager votre score :</span>
                                    <a href="https://twitter.com/intent/tweet?text=Notre+équipe+a+résolu+<?php echo $r['score']; ?>+énigmes+au+Night+Casino+Escape+Game+!+Faites+mieux+!" target="_blank" style="background: #000; color: #fff; padding: 6px 12px; font-size: 0.8rem; text-decoration: none; border: 1px solid #444; font-weight: bold;">Partager sur X</a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=https://sae202-agence.MMI.mmi-troyes.fr" target="_blank" style="background: #3b5998; color: #fff; padding: 6px 12px; font-size: 0.8rem; text-decoration: none; font-weight: bold;">Facebook</a>
                                </div>
                            <?php else: ?>
                                <p style="color: #888; font-style: italic;">⏳ Le score de cette partie sera encodé par l'administrateur de l'événement dès votre sortie de la salle.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php include_once("view/footer.php"); ?>