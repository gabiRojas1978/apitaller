<?php

//mostrar errores
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'php_error_log');

//requerimientos
require_once 'controllers/routes.controller.php';

$index = new Routes_controller();
$index->index();
