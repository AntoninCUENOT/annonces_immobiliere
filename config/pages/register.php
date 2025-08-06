<?php
require_once '../models/RegisterModel.php';
require_once '../views/RegisterFormView.php';
require_once '../controllers/RegisterController.php';

use Controllers\RegisterController;

$controller = new RegisterController();
$controller->handleRequest();
?>
<script src="../assets/script.js"></script>
