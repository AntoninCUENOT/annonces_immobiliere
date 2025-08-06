<?php
namespace Controllers;

use Models\LoginModel;
use Views\LoginFormView;

class LoginController
{
    public function handleRequest(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new LoginModel($_POST);
            if ($model->isValid()) {
                $data = $model->getData();
                echo "<pre>Connexion réussie (données reçues) :\n";
                print_r($data);
                echo "</pre>";
            } else {
                echo "<p style='color:red; text-align:center;'>Tous les champs sont requis.</p>";
            }
        }

        $view = new LoginFormView();
        $view->render();
    }
}
