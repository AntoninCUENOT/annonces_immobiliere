<?php

namespace App\Controllers\Annonces;

require_once __DIR__ . "/../Auth.php";

use App\Models\Annonces\AddModel;
use App\Views\Annonces\AddFormView;
use Config\Auth;

class AddController
{
    public function handleRequest(): void
    {
        // Vérifie l'autorisation AVANT toute autre logique
        Auth::checkAccess(['agent', 'admin']);

        $model = new AddModel();
        $result = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $model->validateForm($_POST);

            if ($result['success']) {
                $_POST = [];
            }
        }

        // Récupérer les types dynamiquement depuis le modèle
        $propertyTypes = $model->getPropertyTypes();
        $transactionTypes = $model->getTransactionTypes();

        $view = new AddFormView();
        $view->render($result, $propertyTypes, $transactionTypes);
    }
}
