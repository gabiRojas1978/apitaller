<?php
// Establecer cabeceras CORS
header('Access-Control-Allow-Origin: *'); // Permite todas las fuentes
header('Access-Control-Allow-Methods: GET, POST,PUT, DELETE'); // Permite métodos
header('Access-Control-Allow-Headers: Origin, X-Requested-With,Content-Type, Accept'); // Permite encabezados específicos
header('Content-Type: application/json, charset=utf-8');
//mostrar errores
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'php_error_log');

// Requerimientos
require_once 'controllers/routes.controller.php';

// Instanciación y ejecución
$index = new Routes_controller();
$index->index();
