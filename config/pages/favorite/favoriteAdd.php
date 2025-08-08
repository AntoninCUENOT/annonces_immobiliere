<?php
require_once './config/models/FavoriteModel.php';
require_once './config/views/FavoriteView.php';
require_once './config/controllers/FavoriteController.php';

use Controllers\FavoriteController;

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: /annonces');
    exit;
}

$listingId = (int)$_GET['id'];

$controller = new FavoriteController();
$controller->addFavorite($listingId);
