<?php
$id_equipe = $_SESSION['user_id'];
$score = recuperer_score($link, $id_equipe); [cite: 52]

$msg_avis = "";
if (isset($_POST['action_avis'])) {
    if (ajouter_avis($link, $id_equipe, $_POST['commentaire'])) { [cite: 54]
        $msg_avis = "<p style='color:green;'>Avis envoyé au croupier pour vérification !</p>";
    }
}
?>