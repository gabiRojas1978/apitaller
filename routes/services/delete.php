<?php

require_once "controllers/delete.controller.php";
$table = explode("?", $routesArray[1])[0];

$response = new DeleteController();
if (isset($_GET['SE'])) {
    $response->deleteData($table, $_GET['id'], $_GET['SE'], $_GET['nameId'], $_GET['nameIdSE']);
} else if (isset($_GET['idSuministro'])) {
    $response->deleteDataSuministro($table, $_GET['idSuministro']);
} else if (isset($_GET['idLote'])) {
    $response->deleteDataLote($table, $_GET['idLote']);
} else {
    $response->deleteDataGeneric($table, $_GET['id'], $_GET['nameId']);
}
