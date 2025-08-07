<?php

namespace App\Controllers;

use App\Models\AddModel;
use App\Views\AddFormView;

class AddController
{
    public function handleRequest(): void
    {
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
