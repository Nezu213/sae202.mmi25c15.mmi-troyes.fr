<?php
require_once '/var/www/html/sae202_event/view/bdd.php';

//<editor-fold desc="Fonctions pour la gestion des avis">
function get_avis_a_valider() {
    $bdd = bdd();
    $query = $bdd->prepare("SELECT id_avis, id_equipes, commentaire, note, approuve FROM avis WHERE approuve = 0");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function approuver_commentaire($id_avis) {
    $bdd = bdd();
    $query = $bdd->prepare("UPDATE avis SET approuve = 1 WHERE id_avis = ?");
    return $query->execute([$id_avis]);
}

function supprimer_commentaire($id_avis) {
    $bdd = bdd();
    $query = $bdd->prepare("DELETE FROM avis WHERE id_avis = ?");
    return $query->execute([$id_avis]);
}
//</editor-fold>

//<editor-fold desc="Fonctions pour la gestion des équipes (Inscription/Connexion)">

/**
 * Crée une nouvelle équipe dans la base de données.
 */
function creer_equipe($nom_equipe, $mot_de_passe_clair, $nombre_participants) {
    $bdd = bdd();
    $mot_de_passe_hache = password_hash($mot_de_passe_clair, PASSWORD_DEFAULT);
    $query = $bdd->prepare("INSERT INTO equipes (nom_groupe, mot_de_passe, nombre_participants) VALUES (?, ?, ?)");
    return $query->execute([$nom_equipe, $mot_de_passe_hache, $nombre_participants]);
}

/**
 * Vérifie si un nom d'équipe existe déjà.
 */
function nom_equipe_existe($nom_equipe) {
    $bdd = bdd();
    $query = $bdd->prepare("SELECT COUNT(*) FROM equipes WHERE nom_groupe = ?");
    $query->execute([$nom_equipe]);
    return $query->fetchColumn() > 0;
}

/**
 * Récupère les informations d'une équipe par son nom.
 */
function get_equipe_by_name($nom_equipe) {
    $bdd = bdd();
    $query = $bdd->prepare("SELECT * FROM equipes WHERE nom_groupe = ?");
    $query->execute([$nom_equipe]);
    return $query->fetch(PDO::FETCH_ASSOC);
}
//</editor-fold>
?>