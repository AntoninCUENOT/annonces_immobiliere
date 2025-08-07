<?php
require_once './config/models/annonces/DeleteAnnonceModel.php';
require_once './config/controllers/annonces/DeleteAnnonceController.php';

$controller = new \Controllers\DeleteAnnonceController();
$controller->handleRequest();
