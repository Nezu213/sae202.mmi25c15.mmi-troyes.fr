<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../view/bdd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pseudo'])) {
    $pseudo = trim($_POST['pseudo']);
    $password_saisi = $_POST['password'] ?? '';

    // Recherche par pseudo dans la table user
    $query = $link->prepare("SELECT * FROM user WHERE user_pseudo = ?");
    $query->execute([$pseudo]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    // Vérification avec password_verify sur la colonne user_mot_de_passe
    if ($user && password_verify($password_saisi, $user['user_mot_de_passe'])) {
        
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['pseudo'] = $user['user_pseudo'];
        $_SESSION['user_email'] = $user['user_email'];

        if ($user['user_email'] === 'marilou.londole-lokoola@etudiant.univ-reims.fr') {
            $_SESSION['role'] = 'admin';
        } else {
            $role_bdd = $user['user_rôle'] ?? $user['user_role'] ?? 'participant';
            $_SESSION['role'] = strtolower(trim($role_bdd));
        }

        session_write_close();

        // Redirection adaptée à l'emplacement de ton dossier d'administration
        if ($_SESSION['role'] === 'admin') {
            header('Location: ../gestion/index.php');
            exit();
        } else {
            header('Location: ../profil.php');
            exit();
        }
    } else {
        header('Location: ../connexion.php?error=1');
        exit();
    }
} else {
    header('Location: ../connexion.php');
    exit();
}
?>