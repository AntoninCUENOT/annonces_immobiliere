<?php

namespace Config\Controllers;

use Config\Models\ListingModel;
use Config\Views\ListingView;

class ListingController
{
    public function handleRequest(): void
    {
        $model = new ListingModel();

        $maisons = $model->getListingsByPropertyType(1); // House
        $appartements = $model->getListingsByPropertyType(2); // Apartment

        $view = new ListingView();
        $view->renderSeparated($maisons, $appartements);
    }
}
