<?php
require_once './config/models/AddModel.php';
require_once './config/views/AddFormView.php';
require_once './config/controllers/AddController.php';

use App\Controllers\AddController;

$controller = new AddController();
$controller->handleRequest();
?>
<script src="./assets/js/validation.js"></script>