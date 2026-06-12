<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../../index.php'); 
    exit();
}


require_once '../../model/admin_model.php';

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id_avis = (int)$_GET['id'];

    if ($_GET['action'] === 'approuver') {
        approuver_commentaire($id_avis);
    } elseif ($_GET['action'] === 'supprimer') {
        supprimer_commentaire($id_avis);
    }

    header('Location: ../view/admin.php');
    exit();
}

$avis_a_valider = get_avis_a_valider();

?>