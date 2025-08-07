<?php

namespace Controllers\Annonces;

require_once __DIR__ . "/../Auth.php";

use Models\Annonces\ListAnnoncesModel;
use Config\Auth;

class ListAnnoncesController
{
    public function handleRequest(): void
    {
        if (!isset($_SESSION['user'], $_SESSION['role'], $_SESSION['user_id'])) {
            $_SESSION['error'] = "Veuillez vous connecter.";
            header("Location: ?page=login");
            exit();
        }
        // Vérifie l'autorisation AVANT toute autre logique
        Auth::checkAccess(['agent', 'admin']);

        $role = $_SESSION['role'];
        $userId = $_SESSION['user_id'];

        $model = new ListAnnoncesModel();
        $annonces = $model->getAnnoncesByRole($role, $userId);

        require_once __DIR__ . '/../../views/annonces/ListAnnoncesView.php';
        $view = new \Views\Annonces\ListAnnoncesView();
        $view->render($annonces, $role);
    }
}
