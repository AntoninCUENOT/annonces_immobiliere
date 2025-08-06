<?php
namespace Controllers;

use Models\RegisterModel;
use Views\RegisterFormView;

class RegisterController
{
    public function handleRequest(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new RegisterModel($_POST);
            if ($model->isValid()) {
                $data = $model->getData();
                echo "<pre>Inscription réussie (données reçues) :\n";
                print_r($data);
                echo "</pre>";
            } else {
                echo "<p style='color:red; text-align:center;'>Vérifiez les champs et la confirmation du mot de passe.</p>";
            }
        }

        $view = new RegisterFormView();
        $view->render();
    }
}
