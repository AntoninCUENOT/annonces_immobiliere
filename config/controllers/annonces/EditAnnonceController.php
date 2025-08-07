<?php

namespace Controllers;

require_once __DIR__ . "/../Auth.php";

use Models\EditAnnonceModel;
use Config\Auth;

class EditAnnonceController
{
    public function handleRequest(): void
    {
        if (!isset($_SESSION['user'], $_SESSION['role'], $_SESSION['user_id'])) {
            $_SESSION['error'] = "Accès refusé.";
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

        $model = new EditAnnonceModel();
        $annonce = $model->getAnnonceById($annonceId);

        if (!$annonce) {
            $_SESSION['error'] = "Annonce introuvable.";
            header("Location: ?page=annonces");
            exit();
        }

        // Vérifier les droits
        if ($role !== 'admin' && ($role === 'agent' && $annonce['user_id'] != $userId)) {
            $_SESSION['error'] = "Vous n'avez pas les droits pour modifier cette annonce.";
            header("Location: ?page=annonces");
            exit();
        }

        $message = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'price' => $_POST['price'] ?? '',
                'city' => $_POST['city'] ?? '',
                'image_url' => $_POST['image_url'] ?? '',
                'property_type_id' => $_POST['property_type_id'] ?? '',
                'transaction_type_id' => $_POST['transaction_type_id'] ?? ''
            ];

            $updated = $model->updateAnnonce($annonceId, $data);

            if ($updated) {
                $_SESSION['success'] = "Annonce mise à jour.";
                header("Location: ?page=annonces");
                exit();
            } else {
                $message = "Erreur lors de la mise à jour.";
            }
        }

        $propertyTypes = $model->getPropertyTypes();
        $transactionTypes = $model->getTransactionTypes();

        require_once __DIR__ . '/../../views/annonces/EditAnnonceView.php';
        $view = new \Views\EditAnnonceView();
        $view->render($annonce, $propertyTypes, $transactionTypes, $message);
    }
}
