<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("view/header.php");
?>
<main style="padding: 120px 20px; text-align: center; background: #111; color: #fff; min-height: 75vh; font-family: sans-serif;">
    <h1 style="font-size: 90px; color: #c0392b; margin: 0 0 10px 0; font-weight: 900; letter-spacing: 2px;">404</h1>
    <h2 style="font-size: 26px; color: #f1c40f; margin: 0 0 30px 0; letter-spacing: 1px;">ERREUR : VOUS VOUS ÊTES ÉGARÉ DANS LE CASINO</h2>
    <p style="max-width: 600px; margin: 0 auto 40px auto; color: #bbb; line-height: 1.8; font-size: 16px;">
        La porte dérobée que vous tentez de forcer est verrouillée à double tour par la sécurité. Les cartes ont été distribuées, mais il n'y a rien à voir ici. Rebroussez chemin avant que le croupier ne donne l'alerte !
    </p>
    <a href="index.php" style="background: #f1c40f; color: #000; padding: 14px 30px; font-weight: bold; text-decoration: none; border-radius: 4px; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; display: inline-block; transition: background 0.2s;">
        Retourner à la table de jeu
    </a>
</main>
<?php include_once("view/footer.php"); ?>