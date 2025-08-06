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
                echo "<script>
                    alert('Connexion réussie');
                    window.location.href = '?page=dashboard';
                </script>";
                exit();
            } else {
                echo "<p style='color:red; text-align:center;'>Tous les champs sont requis.</p>";
            }
        }

        $view = new LoginFormView();
        $view->render();
    }
}
