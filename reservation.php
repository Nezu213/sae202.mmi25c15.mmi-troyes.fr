<?php
session_start();
include_once("view/header.php");

// --- Sécurité : Vérifier si l'utilisateur est connecté ---
if (!isset($_SESSION['user_id'])) {
    // Si non, on le redirige vers la page de connexion
    header('Location: connexion.php?error=not_logged_in');
    exit();
}

// On récupère les infos de l'utilisateur depuis la session pour les pré-remplir
$user_email = $_SESSION['user_email'] ?? '';
$user_pseudo = $_SESSION['nom_equipe'] ?? ''; // 'nom_equipe' contient le pseudo

?>

<main class="page-reservation">
    <div class="reservation-container">
        <h2 class="titre-reservation">RÉSERVATION</h2>

        <form action="controller/reservation_controller.php" method="POST" class="form-reservation-stylise">
            
            <div class="form-row">
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($user_pseudo); ?>" required>
                </div>
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date" required>
                </div>
            </div>

            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_email); ?>" required>
            </div>

            <div class="form-group">
                <label for="nom_groupe">Nom de groupe</label>
                <input type="text" id="nom_groupe" name="nom_groupe" required>
            </div>

            <div class="form-group">
                <label for="nb_participants">Nombre de participants</label>
                <input type="number" id="nb_participants" name="nb_participants" min="1" max="10" required>
            </div>

            <div class="form-group">
                <label for="mode_jeu">Mode de jeu</label>
                <select id="mode_jeu" name="mode_jeu" required>
                    <option value="" disabled selected>Choisissez un mode...</option>
                    <option value="poker">Poker</option>
                    <option value="blackjack">Blackjack</option>
                    <option value="roulette">Roulette</option>
                </select>
            </div>

            <button type="submit">RÉSERVER</button>

        </form>
    </div>
</main>

<?php include_once("view/footer.php"); ?>