<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../view/bdd.php';
require_once __DIR__ . '/../model/admin_model.php';
require_once __DIR__ . '/../model/avis_model.php';

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'modifier_score':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_session = (int)$_POST['id_session'];
            $nouveau_score = (int)$_POST['nouveau_score'];

            try {
                $query = $link->prepare("UPDATE reservations SET score = :score WHERE id_reservations = :id");
                $query->execute([
                    ':score' => $nouveau_score,
                    ':id' => $id_session
                ]);
                header('Location: ../gestion/index.php?success=score_updated');
                exit();
            } catch (PDOException $e) {
                die("Erreur lors de la mise a jour du score : " . $e->getMessage());
            }
        }
        break;

    case 'supprimer_reservation':
        if (isset($_GET['id'])) {
            $id_reservations = (int)$_GET['id'];
            try {
                $query = $link->prepare("DELETE FROM reservations WHERE id_reservations = :id");
                $query->execute([':id' => $id_reservations]);
                header('Location: ../gestion/index.php?success=reservation_deleted');
                exit();
            } catch (PDOException $e) {
                die("Erreur SQL lors de la suppression de la reservation : " . $e->getMessage());
            }
        } else {
            header('Location: ../gestion/index.php?error=missing_id');
            exit();
        }
        break;

    case 'approuver_avis':
        if (isset($_GET['id'])) {
            $id_avis = (int)$_GET['id'];
            try {
                $query = $link->prepare("UPDATE avis SET est_approuve = 1 WHERE id_avis = ?");
                $query->execute([$id_avis]);
                header('Location: ../gestion/index.php?success=avis_approved');
                exit();
            } catch (PDOException $e) {
                die("Erreur lors de l'approbation de l'avis : " . $e->getMessage());
            }
        }
        break;

    case 'supprimer_avis':
        if (isset($_GET['id'])) {
            $id_avis = (int)$_GET['id'];
            try {
                $query = $link->prepare("DELETE FROM avis WHERE id_avis = ?");
                $query->execute([$id_avis]);
                header('Location: ../gestion/index.php?success=avis_deleted');
                exit();
            } catch (PDOException $e) {
                die("Erreur lors de la suppression de l'avis : " . $e->getMessage());
            }
        }
        break;

    default:
        header('Location: ../gestion/index.php');
        exit();
}
?>