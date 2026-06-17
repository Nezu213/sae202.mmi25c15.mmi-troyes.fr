<?php
require_once __DIR__ . '/../view/bdd.php';

// ============================================================
// GESTION DES AVIS
// ============================================================

function get_avis_a_valider() {
    global $link;
    $query = $link->prepare("
        SELECT a.*, u.user_pseudo
        FROM avis a
        JOIN user u ON a.user_id = u.user_id
        WHERE a.est_approuve = 0 
        ORDER BY a.id_avis DESC
    ");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function approuver_avis($id_avis) {
    global $link;
    $query = $link->prepare("UPDATE avis SET est_approuve = 1 WHERE id_avis = ?");
    return $query->execute([$id_avis]);
}

function get_tous_les_avis_valides() {
    global $link;
    $query = $link->prepare("
        SELECT a.*, u.user_pseudo
        FROM avis a
        JOIN user u ON a.user_id = u.user_id
        WHERE a.est_approuve = 1 
        ORDER BY a.id_avis DESC
    ");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

// ALIAS POUR TON INDEX.PHP
function get_avis_approuves() {
    return get_tous_les_avis_valides();
}

// ============================================================
// AJOUT DE LA FONCTION MANQUANTE (Correction Définitive)
// ============================================================

/**
 * Insère un nouvel avis dans la base de données (en attente de modération admin)
 */
function creer_avis($user_id, $note, $commentaire) {
    global $link;

    try {
        // CORRECTION ICI : Changement de id_user par user_id pour correspondre à ton architecture
        $query = $link->prepare("INSERT INTO avis (user_id, note, commentaire, est_approuve) 
                                 VALUES (:user_id, :note, :commentaire, 0)");
        
        $success = $query->execute([
            ':user_id'     => (int)$user_id,
            ':note'        => (int)$note,
            ':commentaire' => $commentaire
        ]);

        return $success;
    } catch (PDOException $e) {
        // Si un autre problème survient, cela affichera l'erreur SQL de manière transparente
        die("Erreur SQL dans creer_avis() : " . $e->getMessage());
    }
}