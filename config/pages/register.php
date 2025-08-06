<?php
require_once './config/models/RegisterModel.php';
require_once './config/views/RegisterFormView.php';
require_once './config/controllers/RegisterController.php';

use Controllers\RegisterController;

$controller = new RegisterController();
$controller->handleRequest();
?>
<script src="./assets/js/validation.js"></script>
