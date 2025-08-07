<?php
require_once './config/models/annonces/EditAnnonceModel.php';
require_once './config/views/annonces/EditAnnonceView.php';
require_once './config/controllers/annonces/EditAnnonceController.php';

$controller = new \Controllers\EditAnnonceController();
$controller->handleRequest();
