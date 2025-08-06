<?php

use Config\Controllers\ListingController;

require_once './config/controllers/ListingController.php';
require_once './config/models/ListingModel.php';
require_once './config/views/ListingView.php';

$controller = new ListingController();
$controller->handleRequest();
