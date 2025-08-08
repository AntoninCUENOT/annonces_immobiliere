<?php

namespace Config\Controllers;

use Config\Models\ListingModel;
use Config\Views\ListingView;

class ListingController
{
    private const PER_PAGE = 12;

    public function handleRequest(): void
    {
        $model = new ListingModel();
        $view = new ListingView();

        $pageType = $_GET['page'] ?? null;
        $pageNum = isset($_GET['pages']) ? (int)$_GET['pages'] : 1;
        if ($pageNum < 1) {
            header('Location: ?page=' . $pageType . '&pages=1');
            exit;
        }

        if ($pageType === 'Maisons' || $pageType === 'Appartements') {
            $propertyTypeId = ($pageType === 'Maisons') ? 1 : 2;

            $filters = [
                'ville' => $_GET['ville'] ?? null,
                'prix_max' => $_GET['prix_max'] ?? null,
                'transaction_type_id' => $_GET['transaction_type_id'] ?? null,
            ];

            $totalListings = $model->getFilteredListingsCount($propertyTypeId, $filters);
            $totalPages = (int)ceil($totalListings / self::PER_PAGE);

            if ($pageNum > $totalPages && $totalPages > 0) {
                header('Location: ?page=' . $pageType . '&pages=1');
                exit;
            }

            $offset = ($pageNum - 1) * self::PER_PAGE;
            $listings = $model->getFilteredListings($propertyTypeId, self::PER_PAGE, $offset, $filters);

            $view->render($listings, $pageType, $pageNum, $totalPages);
        } else {
            // Filtres uniquement sur la page d’accueil
            $filters = [
                'ville' => $_GET['ville'] ?? null,
                'prix_max' => $_GET['prix_max'] ?? null,
                'transaction_type_id' => $_GET['transaction_type_id'] ?? null,
            ];

            // Détecte si des filtres sont actifs
            $isFilterActive = !empty($filters['ville']) || !empty($filters['prix_max']) || !empty($filters['transaction_type_id']);

            // Si filtres actifs → pas de limite
            $limit = $isFilterActive ? null : 3;
            $offset = 0;

            $maisons = $model->getFilteredListings(1, $limit, $offset, $filters);
            $appartements = $model->getFilteredListings(2, $limit, $offset, $filters);

            $view->renderSeparated($maisons, $appartements, $filters);
        }
    }
}
