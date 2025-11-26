<?php
require_once 'models/connection.php';
require_once 'models/post.model.php';
require_once 'models/put.model.php';
require_once 'models/delete.model.php';
require_once 'models/get.model.php';
$routesArray = explode('/', $_SERVER['REQUEST_URI']);
$routesArray = array_filter($routesArray);
$databaseName = $_SERVER['HTTP_X_SOURCE'];
// Obtén todos los encabezados de la solicitud
$headers = getallheaders();
$token = '';
if (count($routesArray) == 0) {
    echo 'Bienvenido a la api de GR Sistemas';
    return;
}
$login = false;
if (isset($headers['Authorization'])) {
    // Captura el token, eliminando la palabra "Bearer " al inicio
    $token = str_replace('Bearer ', '', $headers['Authorization']);
} else if (isset($_GET['login'])) {
    $login = true;
} else {
    http_response_code(401);
    echo json_encode(["error" => "Token de autorización no proporcionado"]);
    return;
}

$conexion = Connection::connect($databaseName);
if (isset($_SERVER['REQUEST_METHOD'])) {
    GetModel::setConnection($conexion);
    PutModel::setConnection($conexion);
    PostModel::setConnection($conexion);
    DeleteModel::setConnection($conexion);
    if (Connection::tokenValidate($token)) {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            include "services/get.php";
        }
        if ($_SERVER['REQUEST_METHOD'] == "PUT") {
            include "services/put.php";
        }
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            include "services/post.php";
        }
        if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
            include "services/delete.php";
        }
    } else if ($login) {
        include "services/post.php";
    } else {
        echo 'Token incorrecto o expirado: ' . $token;
        return;
    }
}


return;
