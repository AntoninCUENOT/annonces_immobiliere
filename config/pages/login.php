<?php
require_once '../models/LoginModel.php';
require_once '../views/LoginFormView.php';
require_once '../controllers/LoginController.php';

use Controllers\LoginController;

$controller = new LoginController();
$controller->handleRequest();
?>
<script src="../assets/script.js"></script>
