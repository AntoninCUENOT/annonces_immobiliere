<?php

namespace App\Controllers;

use App\Models\AddModel;
use App\Views\AddFormView;

class AddController
{
    public function handleRequest(): void
    {
        $model = new AddModel();

        $formSubmitted = ($_SERVER['REQUEST_METHOD'] === 'POST');

        if ($formSubmitted) {
            $result = $model->validateForm($_POST);
        }

        $view = new AddFormView();
        $view->render(isset($result) ? $result : []);
    }
}
