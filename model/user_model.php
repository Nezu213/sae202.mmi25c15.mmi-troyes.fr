<?php
require_once __DIR__ . '/../view/bdd.php';

function get_user_by_email($email) {
    global $link;
    $query = $link->prepare("SELECT * FROM user WHERE user_email = ?");
    $query->execute([$email]);
    return $query->fetch(PDO::FETCH_ASSOC);
}

function creer_user($email, $mot_de_passe_clair, $pseudo, $telephone, $role = 'participant') {
    global $link;
    $hash = password_hash($mot_de_passe_clair, PASSWORD_DEFAULT);
    
    // Utilisation du nom exact de ta colonne SQL
    $query = $link->prepare(
        "INSERT INTO user (user_email, user_mot_de_passe, user_pseudo, user_telephone, `user_rôle`)
         VALUES (?, ?, ?, ?, ?)"
    );
    return $query->execute([$email, $hash, $pseudo, $telephone, $role]);
}

function email_existe($email) {
    global $link;
    $query = $link->prepare("SELECT COUNT(*) FROM user WHERE user_email = ?");
    $query->execute([$email]);
    return $query->fetchColumn() > 0;
}
?>