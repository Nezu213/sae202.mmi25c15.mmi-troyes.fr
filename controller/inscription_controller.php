<?php
session_start();
require_once '../view/bdd.php'; // Pour la connexion PDO
require_once '../model/user_model.php'; // On aura besoin des fonctions liées aux utilisateurs

// On vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Récupération et nettoyage des données
    $email     = trim($_POST['email'] ?? '');
    $mdp       = trim($_POST['mot_de_passe'] ?? '');
    $mdp2      = trim($_POST['mot_de_passe2'] ?? '');
    $pseudo    = trim($_POST['pseudo'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');

    // --- Validation ---
    if (!$email || !$mdp || !$mdp2 || !$pseudo || !$telephone) {
        header('Location: ../inscription.php?error=missing_fields');
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: ../inscription.php?error=invalid_email');
        exit;
    }
    if (strlen($mdp) < 8) {
        header('Location: ../inscription.php?error=password_too_short');
        exit;
    }
    if ($mdp !== $mdp2) {
        header('Location: ../inscription.php?error=password_mismatch');
        exit;
    }
    // On vérifie si l'email existe déjà
    if (get_user_by_email($email)) {
        header('Location: ../inscription.php?error=email_exists');
        exit;
    }

    // --- Création de l'utilisateur ---
    $role = ($email === 'admin@evenement.fr') ? 'admin' : 'participant';
    
    // On appelle la fonction pour créer l'utilisateur en passant le mot de passe en clair.
    // Le hachage se fait dans la fonction creer_user pour une meilleure organisation.
    $success = creer_user($email, $mdp, $pseudo, $telephone, $role);

    if ($success) {
        // Redirection vers la page de succès ou de connexion
        header('Location: ../inscription.php?success=true');
        exit();
    } else {
        // Erreur lors de la création en base de données
        header('Location: ../inscription.php?error=db_error');
        exit();
    }

} else {
    // Redirection si on accède au fichier directement
    header('Location: ../inscription.php');
    exit();
}
?>