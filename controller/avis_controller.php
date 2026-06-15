<?php
session_start();
require_once '../model/avis_model.php';

// Vérifier si l'utilisateur est connecté et si la méthode est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    
    // Nettoyer et valider les données
    $user_id = $_SESSION['user_id'];
    $note = filter_input(INPUT_POST, 'note', FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 5]]);
    $commentaire = trim(filter_input(INPUT_POST, 'commentaire', FILTER_SANITIZE_STRING));

    if ($note && !empty($commentaire)) {
        // Si les données sont valides, on crée l'avis
        creer_avis($user_id, $note, $commentaire);
        // Redirection vers la page d'accueil avec un message de succès
        header('Location: ../index.php?avis=success#avis');
        exit();
    } else {
        // Sinon, redirection avec un message d'erreur
        header('Location: ../index.php?avis=error#avis');
        exit();
    }
} else {
    // Si l'accès n'est pas autorisé, on redirige simplement vers l'accueil
    header('Location: ../index.php');
    exit();
}