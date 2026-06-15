<?php
// On inclut directement la BDD qui gère déjà le session_start() proprement
require_once '../view/bdd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = trim($_POST['email']);

    $query = "SELECT * FROM user WHERE user_email = :email";
    $stmt = $link->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Stockage direct des données dans la session active
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['pseudo'] = $user['user_pseudo'] ?? 'Admin';
        $_SESSION['user_email'] = $user['user_email'];

        if ($user['user_email'] === 'marilou.londole-lokoola@etudiant.univ-reims.fr') {
            $_SESSION['role'] = 'admin';
        } else {
            $role_bdd = $user['user_rôle'] ?? $user['user_role'] ?? 'participant';
            $_SESSION['role'] = strtolower(trim($role_bdd));
        }

        // On force l'écriture sur le disque avant de rediriger
        session_write_close();

        if ($_SESSION['role'] === 'admin') {
            header('Location: ../admin.php');
            exit();
        } else {
            header('Location: ../profil.php');
            exit();
        }
    } else {
        header('Location: ../connexion.php?error=not_found');
        exit();
    }
} else {
    header('Location: ../connexion.php');
    exit();
}