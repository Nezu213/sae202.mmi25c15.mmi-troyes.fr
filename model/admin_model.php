<?php
require_once __DIR__ . '/../view/bdd.php';

// ============================================================
// AUTHENTIFICATION ADMIN
// ============================================================

function get_admin_by_email($email) {
    global $link;
    $query = $link->prepare("SELECT * FROM admin WHERE admin_email = ?");
    $query->execute([$email]);
    return $query->fetch(PDO::FETCH_ASSOC);
}

// ============================================================
// DONNÉES PARTICIPANTS (réservations)
// ============================================================

function get_toutes_reservations_admin() {
    global $link;
    $query = $link->prepare(
        "SELECT r.*, u.user_pseudo, u.user_email AS user_email_compte
         FROM reservations r
         LEFT JOIN user u ON r.user_id = u.user_id
         ORDER BY r.date_reservations DESC"
    );
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function compter_reservations() {
    global $link;
    $query = $link->prepare("SELECT COUNT(*) FROM reservations");
    $query->execute();
    return (int) $query->fetchColumn();
}

function compter_participants_total() {
    global $link;
    $query = $link->prepare("SELECT COALESCE(SUM(nb_joueurs),0) FROM reservations");
    $query->execute();
    return (int) $query->fetchColumn();
}

// ============================================================
// AVIS — validation
// ============================================================

function refuser_avis($id_avis) {
    global $link;
    $query = $link->prepare("DELETE FROM avis WHERE id_avis = ?");
    return $query->execute([$id_avis]);
}

function get_tous_les_utilisateurs() {
    global $link;
    $query = $link->prepare("SELECT * FROM user ORDER BY user_id DESC");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function supprimer_utilisateur($user_id) {
    global $link;
    if (isset($_SESSION['user_id']) && $user_id == $_SESSION['user_id']) {
        return false;
    }
    $query = $link->prepare("DELETE FROM user WHERE user_id = ?");
    return $query->execute([$user_id]);
}

function compter_avis_attente() {
    global $link;
    $query = $link->prepare("SELECT COUNT(*) FROM avis WHERE est_approuve = 0");
    $query->execute();
    return (int) $query->fetchColumn();
}

function get_stats_dashboard() {
    return [
        'total_reservations' => compter_reservations(),
        'total_joueurs' => compter_participants_total(),
        'avis_en_attente' => compter_avis_attente()
    ];
}
?>