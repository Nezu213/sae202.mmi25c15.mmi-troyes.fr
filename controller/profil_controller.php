<?php
// controller/profil_controller.php
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
    $pseudo  = trim($_POST['pseudo'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $tel     = trim($_POST['telephone'] ?? '');

    if (!empty($pseudo) && !empty($email) && !empty($tel)) {
        try {
            // Mise à jour de la table 'user'
            // On s'adapte à la structure avec ou sans accent pour éviter tout crash
            $query = "UPDATE user SET user_pseudo = :pseudo, user_email = :email, user_telephone = :tel WHERE user_id = :id";
            $stmt = $link->prepare($query);
            $stmt->execute([
                ':pseudo' => $pseudo,
                ':email'  => $email,
                ':tel'    => $tel,
                ':id'     => $user_id
            ]);

            // Synchronisation de la session active pour l'en-tête du site
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