<?php
// Démarrage de la session si elle n'est pas déjà active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclusion du fichier de configuration
require_once(__DIR__ . '/../conf/conf.inc.php');

try {
    // Tentative de connexion avec PDO
    $link = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
    
    // Configuration de PDO pour qu'il lance des exceptions en cas d'erreur
    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // En cas d'erreur de connexion, on arrête le script et on affiche un message
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>