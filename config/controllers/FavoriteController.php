<?php

namespace Controllers;

use Models\FavoriteModel;
use Views\FavoriteView;

class FavoriteController
{
    private FavoriteModel $favoriteModel;
    private FavoriteView $favoriteView;

    public function __construct()
    {
        $this->favoriteModel = new FavoriteModel();
        $this->favoriteView = new FavoriteView();
    }

    public function addFavorite(int $listingId): void
    {
        if (!isset($_SESSION['user_id'])) {
            echo "Connexion requise.";
            return;
        }

        $this->favoriteModel->addFavorite($_SESSION['user_id'], $listingId);
        header('Location: /annonce/' . $listingId);
        exit;
    }

    public function removeFavorite(int $listingId): void
    {
        if (!isset($_SESSION['user_id'])) {
            echo "Connexion requise.";
            return;
        }

        $this->favoriteModel->removeFavorite($_SESSION['user_id'], $listingId);
        header('Location: /annonce/' . $listingId);
        exit;
    }

    public function showFavorites(): void
    {
        if (!isset($_SESSION['user_id'])) {
            echo "Connexion requise.";
            return;
        }

        $favorites = $this->favoriteModel->getFavoritesByUser($_SESSION['user_id']);
        $this->favoriteView->renderFavoritesPage($favorites);
    }
}
