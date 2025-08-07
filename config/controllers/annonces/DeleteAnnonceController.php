<?php

namespace Controllers;

require_once __DIR__ . "/../Auth.php";

use Models\DeleteAnnonceModel;
use Config\Auth;

class DeleteAnnonceController
{
    public function handleRequest(): void
    {
        if (!isset($_SESSION['user'], $_SESSION['role'], $_SESSION['user_id'])) {
            $_SESSION['error'] = "Accès interdit.";
            header("Location: ?page=login");
            exit();
        }
        // Vérifie l'autorisation AVANT toute autre logique
        Auth::checkAccess(['agent', 'admin']);

        $role = $_SESSION['role'];
        $userId = $_SESSION['user_id'];

        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = "ID invalide.";
            header("Location: ?page=annonces");
            exit();
        }

        $annonceId = (int)$_GET['id'];

        $model = new DeleteAnnonceModel();
        $annonceOwnerId = $model->getAnnonceOwner($annonceId);

        if ($annonceOwnerId === null) {
            $_SESSION['error'] = "Annonce introuvable.";
            header("Location: ?page=annonces");
            exit();
        }

        // Vérification des droits
        if ($role !== 'admin' && ($role === 'agent' && $annonceOwnerId !== $userId)) {
            $_SESSION['error'] = "Vous n'avez pas les droits pour supprimer cette annonce.";
            header("Location: ?page=annonces");
            exit();
        }

        // Suppression
        $success = $model->deleteAnnonce($annonceId);

        $_SESSION[$success ? 'success' : 'error'] = $success
            ? "Annonce supprimée avec succès."
            : "Erreur lors de la suppression.";

        header("Location: ?page=annonces");
        exit();
    }
}
