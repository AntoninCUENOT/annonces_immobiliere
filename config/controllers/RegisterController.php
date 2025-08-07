<?php

namespace Controllers;

use Models\RegisterModel;
use Views\RegisterFormView;

class RegisterController
{
    public function handleRequest(): void
    {
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new RegisterModel($_POST);

            if ($model->register()) {               
                header("Location: ?page=login");
                $message = "<p style='color:green; text-align:center;'>Inscription réussie ! Vous pouvez maintenant vous connecter.</p>";
                exit;
            } else {
                $message = "<p style='color:red; text-align:center;'>Email déjà utilisé ou champs invalides.</p>";
            }
        }

        $view = new RegisterFormView();
        $view->render($message);
    }
}
