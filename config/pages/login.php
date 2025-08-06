<?php
require_once './config/models/LoginModel.php';
require_once './config/views/LoginFormView.php';
require_once './config/controllers/LoginController.php';

use Controllers\LoginController;

$controller = new LoginController();
$controller->handleRequest();
?>
<script src="./assets/js/validation.js"></script>
