<?php

require_once "controllers/delete.controller.php";
$table = explode("?", $routesArray[1])[0];

$response = new DeleteController();
$response->deleteData($table, $_GET['id'], $_GET['SE'], $_GET['nameId'], $_GET['nameIdSE']);
