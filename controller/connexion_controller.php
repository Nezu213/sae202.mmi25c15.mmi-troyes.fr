<?php
session_start();
// On inclut le fichier qui gère la connexion à la BDD
require_once '../view/bdd.php';

// On vérifie si le formulaire a été soumis et si l'email est présent
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    
    // Nettoyage de l'e-mail pour la sécurité
    $email = trim($_POST['email']);

    // On prépare la requête pour trouver l'utilisateur par son e-mail dans la table USER
    $query = "SELECT * FROM user WHERE user_email = :email";
    $stmt = $link->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    // On récupère l'utilisateur
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si un utilisateur a été trouvé
    if ($user) {
        // On stocke les informations de l'utilisateur en session
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['nom_equipe'] = $user['user_pseudo']; // On utilise le pseudo
        $_SESSION['user_email'] = $user['user_email'];
        $_SESSION['role'] = $user['user_rôle'];
        
        // On redirige vers la page de réservation
        header('Location: ../reservation.php');
        exit();
    } else {
        // L'e-mail n'a pas été trouvé, on redirige vers la page de connexion avec un message d'erreur
        header('Location: ../connexion.php?error=not_found');
        exit();
    }
} else {
    // Si quelqu'un essaie d'accéder à ce fichier sans soumettre le formulaire, on le redirige
    header('Location: ../connexion.php');
    exit();
}
?>