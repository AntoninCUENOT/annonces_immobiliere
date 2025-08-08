<?php
require_once './config/models/FavoriteModel.php';
require_once './config/views/FavoriteView.php';
require_once './config/controllers/FavoriteController.php';

use Controllers\FavoriteController;

$controller = new FavoriteController();
$controller->showFavorites();
