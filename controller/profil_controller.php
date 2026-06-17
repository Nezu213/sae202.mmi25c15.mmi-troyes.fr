<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Protection : l'utilisateur doit être authentifié
if (!isset($_SESSION['user_id'])) {
    header('Location: ../connexion.php');
    exit();
}

require_once '../view/bdd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = (int)$_SESSION['user_id'];

    // ACCORD SUPPRESSION COMPTE : Si le bouton "delete_account" a été cliqué
    if (isset($_POST['delete_account'])) {
        try {
            // 1. Suppression des réservations liées à l'équipe pour nettoyer la table
            $del_res = $link->prepare("DELETE FROM reservations WHERE user_id = ?");
            $del_res->execute([$user_id]);

            // 2. Suppression des avis soumis par l'équipe
            $del_avis = $link->prepare("DELETE FROM avis WHERE user_id = ?");
            $del_avis->execute([$user_id]);

            // 3. Suppression de la ligne utilisateur
            $query = $link->prepare("DELETE FROM user WHERE user_id = ?");
            $query->execute([$user_id]);

            // 4. Destruction de la session
            session_destroy();

            header('Location: ../index.php?account=deleted');
            exit();
        } catch (PDOException $e) {
            die("Erreur lors de la suppression de votre compte : " . $e->getMessage());
        }
    }

    // TRAITEMENT DE MODIFICATION CLASSIQUE
    $pseudo  = trim($_POST['pseudo'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $tel     = trim($_POST['telephone'] ?? '');

    if (!empty($pseudo) && !empty($email) && !empty($tel)) {
        try {
            $query = "UPDATE user SET user_pseudo = :pseudo, user_email = :email, user_telephone = :tel WHERE user_id = :id";
            $stmt = $link->prepare($query);
            $stmt->execute([
                ':pseudo' => $pseudo,
                ':email'  => $email,
                ':tel'    => $tel,
                ':id'     => $user_id
            ]);

            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['user_email'] = $email;

            header('Location: ../profil.php?success=profil_updated');
            exit();
        } catch (PDOException $e) {
            die("Erreur de mise à jour des données de l'équipe : " . $e->getMessage());
        }
    } else {
        header('Location: ../profil.php?error=missing_fields');
        exit();
    }
} else {
    header('Location: ../profil.php');
    exit();
}
?>