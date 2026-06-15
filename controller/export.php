<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Securite : Verification que c'est bien l'admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Acces refuse.");
}

require_once __DIR__ . '/../view/bdd.php';
require_once __DIR__ . '/../model/admin_model.php';

// Configuration des en-tetes pour declencher le telechargement du fichier
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=export_reservations_' . date('Y-m-d') . '.csv');

// Ouverture du flux de sortie de PHP
$output = fopen('php://output', 'w');

// Insertion de la ligne d'entete (on force l'UTF-8 pour Excel avec le BOM)
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
fputcsv($output, array('Nom du Groupe', 'Responsable / Email', 'Date de Reservation', 'Nombre de Joueurs', 'Score obtenu'));

// Recuperation des vraies donnees de la base
$equipes = get_toutes_reservations_admin();

if (!empty($equipes)) {
    foreach ($equipes as $equipe) {
        fputcsv($output, array(
            $equipe['nom_groupe'] ?? 'Sans nom',
            $equipe['user_email_compte'] ?? $equipe['user_pseudo'] ?? 'N/A',
            isset($equipe['date_reservations']) ? date('d/m/Y', strtotime($equipe['date_reservations'])) : 'N/A',
            $equipe['nb_joueurs'] ?? 0,
            $equipe['score'] ?? 0
        ));
    }
}

fclose($output);
exit();
?>