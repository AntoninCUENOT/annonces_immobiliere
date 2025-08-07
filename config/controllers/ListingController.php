<?php

namespace Config\Controllers;

use Config\Models\ListingModel;
use Config\Views\ListingView;

class ListingController
{
    public function handleRequest(): void
    {
        $model = new ListingModel();
        $view = new ListingView();

        $page = $_GET['page'] ?? null;

        if ($page === 'Maisons') {
            $maisons = $model->getListingsByPropertyType(1); 
            $view->render($maisons);
        } elseif ($page === 'Appartements') {
            $appartements = $model->getListingsByPropertyType(2);
            $view->render($appartements);
        } else {
            $maisons = $model->getListingsByPropertyType(1, 3);
            $appartements = $model->getListingsByPropertyType(2, 3);
            $view->renderSeparated($maisons, $appartements);
        }
    }
}

