<?php

require_once "controllers/put.controller.php";
require_once "models/connection.php";

$table = explode("?", $routesArray[1])[0];
if (isset($_GET['id']) && isset($_GET['nameId'])) {
    // Decodifica el JSON recibido
    $data = json_decode(file_get_contents("php://input"), true);

    // Verifica que $data se haya decodificado correctamente
    if (json_last_error() === JSON_ERROR_NONE) {
        $response = new PutController();
        $response->putData($table, $data, $_GET['id'], $_GET['nameId']);
    } else {
        echo "Error en la decodificación de JSON";
    }
} else {
    echo 'Faltan datos';
}
