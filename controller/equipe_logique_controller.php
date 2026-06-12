<?php
$msg = "";
if (isset($_POST['action_inscription'])) { [cite: 33]
    $succes = inscrire_equipe(
        $link, 
        $_POST['nom'], 
        $_POST['prenom'], 
        $_POST['email'], 
        $_POST['nom_groupe'], 
        $_POST['participants']
    );

    if ($succes) { [cite: 54]
        $msg = "<p style='color:green;'>Votre table est réservée ! Connectez-vous.</p>";
    } else { [cite: 54]
        $msg = "<p style='color:red;'>Erreur : Cet e-mail est déjà utilisé.</p>";
    }
}
?>