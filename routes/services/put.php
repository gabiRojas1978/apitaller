<?php

require_once "controllers/put.controller.php";
require_once "models/connection.php";
if (isset($_GET['token'])) {
    if (Connection::tokenValidate($_GET['token'])) {
        $table = explode("?", $routesArray[1])[0];
        if (isset($_GET['id']) && isset($_GET['nameId'])) {
            $data = array();
            parse_str(file_get_contents('php://input'), $data);
            $response = new PutController();
            $response->putData($table, $data, $_GET['id'], $_GET['nameId']);
        } else {
            echo 'Faltan datos';
        }
    } else {
        echo 'token incorrecto o expirado';
        return;
    }
} else {
    echo 'Error: Peticion sin token';
    return;
}
