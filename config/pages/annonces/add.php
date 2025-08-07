<?php
require_once './config/models/annonces/AddModel.php';
require_once './config/views/annonces/AddFormView.php';
require_once './config/controllers/annonces/AddController.php';

use App\Controllers\Annonces\AddController;

$controller = new AddController();
$controller->handleRequest();
?>
<script src="./assets/js/validation.js"></script>