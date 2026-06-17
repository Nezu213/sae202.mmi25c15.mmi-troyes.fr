<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['token'], $_POST['password'], $_POST['confirm_password'])) {
    require_once '../view/bdd.php';
    
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        header('Location: ../reset_password.php?token=' . urlencode($token) . '&error=mismatch');
        exit;
    }

    // On revérifie l'intégrité du token
    $stmt = $link->prepare("SELECT user_id FROM user WHERE user_reset_token = ? AND user_reset_expires > NOW()");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        // Optionnel mais recommandé : Hacher le mot de passe si tu gères l'inscription hachée
        // $new_password = password_hash($password, PASSWORD_DEFAULT);
        $new_password = $password; // Laisse brut uniquement si tes contrôleurs de connexion actuels lisent du brut

        // Mise à jour du mot de passe et destruction du token
        $update = $link->prepare("UPDATE user SET user_mot_de_pass = ?, user_reset_token = NULL, user_reset_expires = NULL WHERE user_id = ?");
        $update->execute([$new_password, $user['user_id']]);

        // Redirection vers la connexion avec succès !
        header('Location: ../connexion.php?success=password_changed');
        exit;
    } else {
        header('Location: ../mdp_oublie.php?error=expired');
        exit;
    }
} else {
    header('Location: ../connexion.php');
    exit;
}