<?php
require_once './config/models/annonces/ListAnnoncesModel.php';
require_once './config/views/annonces/ListAnnoncesView.php';
require_once './config/controllers/annonces/ListAnnoncesController.php';

$controller = new \Controllers\Annonces\ListAnnoncesController();
$controller->handleRequest();
