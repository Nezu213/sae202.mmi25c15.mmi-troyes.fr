<?php
$error = "";
if (isset($_POST['action_connexion'])) {
    $equipe = recuperer_equipe_par_email($link, $_POST['email']);

    if ($equipe && password_verify($_POST['mot_de_passe'], $equipe['mot_de_passe'])) {
        // Le mot de passe est correct, on peut connecter l'utilisateur
        $_SESSION['user_id'] = $equipe['id_equipes'];
        $_SESSION['nom_equipe'] = $equipe['nom_groupe'];
        
        // Simulation du rôle d'administrateur de Troyes
        if ($equipe['email'] === 'admin@mmi-troyes.fr') {
            $_SESSION['role'] = 'admin';
        } else {
            $_SESSION['role'] = 'participant';
        }
        
        header("Location: index.php?page=profil");
        exit();
    } else {
        // Si l'équipe n'existe pas OU si le mot de passe est incorrect
        $error = "<p style='color:red;'>L'adresse e-mail ou le mot de passe est incorrect.</p>";
    }
}
?>