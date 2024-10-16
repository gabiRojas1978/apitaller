<?php

require_once "controllers/put.controller.php";
$table = explode("?", $routesArray[1])[0];
if (isset($_GET['id']) && isset($_GET['nameId'])) {
    $data = array();
    parse_str(file_get_contents('php://input'), $data);
}

$response = new PutController();
$response->putData($table, $data, $_GET['id'], $_GET['nameId']);
