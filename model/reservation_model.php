<?php
require_once __DIR__ . '/../view/bdd.php';

// ============================================================
// MODÈLE RESERVATION
// ============================================================

/**
 * Crée une réservation en base
 */
function creer_reservation($nom, $date, $email, $nom_groupe, $nb_joueurs, $mode, $user_id) {
    global $link;
    $query = $link->prepare(
        "INSERT INTO reservations
            (nom, date_reservations, email, nom_groupe, nb_joueurs, mode_jeu, user_id,
             montant_reservations, status_paiement_reservations)
         VALUES (?, ?, ?, ?, ?, ?, ?, 0, 'en_attente')"
    );
    return $query->execute([$nom, $date, $email, $nom_groupe, $nb_joueurs, $mode, $user_id]);
}

/**
 * Récupère les réservations d'un utilisateur
 */
function get_reservations_by_user($user_id) {
    global $link;
    $query = $link->prepare(
        "SELECT * FROM reservations WHERE user_id = ? ORDER BY date_reservations DESC"
    );
    $query->execute([$user_id]);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère toutes les réservations (admin)
 */
function get_toutes_reservations() {
    global $link;
    $query = $link->prepare(
        "SELECT r.*, u.user_pseudo, u.user_email
         FROM reservations r
         LEFT JOIN user u ON r.user_id = u.user_id
         ORDER BY r.date_reservations DESC"
    );
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}