<?php
session_start();

// On simule une connexion réussie en base de données
$_SESSION['user_id'] = 1;
$_SESSION['pseudo'] = 'Marilou';
$_SESSION['user_email'] = 'marilou.londole-lokoola@etudiant.univ-reims.fr';
$_SESSION['role'] = 'admin'; // En minuscules !

echo "Session forcée avec succès ! <a href='admin.php'>Aller sur la page Admin</a>";