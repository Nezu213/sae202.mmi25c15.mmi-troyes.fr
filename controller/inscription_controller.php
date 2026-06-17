<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../view/bdd.php'; 
require_once '../model/user_model.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Récupération des champs du formulaire de la maquette
    $pseudo    = trim($_POST['pseudo'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $mdp       = trim($_POST['mot_de_passe'] ?? '');
    $mdp2      = trim($_POST['mot_de_passe2'] ?? '');

    // Validation
    if (empty($pseudo) || empty($email) || empty($telephone) || empty($mdp) || empty($mdp2)) {
        header('Location: ../inscription.php?error=missing_fields');
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: ../inscription.php?error=invalid_email');
        exit();
    }
    if (strlen($mdp) < 8) {
        header('Location: ../inscription.php?error=password_too_short');
        exit();
    }
    if ($mdp !== $mdp2) {
        header('Location: ../inscription.php?error=password_mismatch');
        exit();
    }
    if (get_user_by_email($email)) {
        header('Location: ../inscription.php?error=email_exists');
        exit();
    }

    // Détermination du rôle admin
    $role = ($email === 'marilou.londole-lokoola@etudiant.univ-reims.fr') ? 'admin' : 'participant';
    
    // Insertion via le modèle aligné
    $success = creer_user($email, $mdp, $pseudo, $telephone, $role);

    if ($success) {
        header('Location: ../inscription.php?success=true');
        exit();
    } else {
        header('Location: ../inscription.php?error=db_error');
        exit();
    }
} else {
    header('Location: ../inscription.php');
    exit();
}
?>