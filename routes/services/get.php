<?php
require_once "controllers/get.controller.php";
$table = explode("?", $routesArray[1])[0];
$select = $_GET["select"] ?? "*";
$orderBy = $_GET["orderBy"] ?? null;
$orderMode = $_GET["orderMode"] ?? null;
$startAt = $_GET["startAt"] ?? null;
$endAt = $_GET["endAt"] ?? null;
$filterTo = $_GET["filterTo"] ?? null;
$inTo = $_GET["inTo"] ?? null;
$distinct = $_GET["distinct"] ?? null;
$sum = $_GET["sum"] ?? null;
$groupBy = $_GET["groupBy"] ?? null;
$linkTo = $_GET['linkTo'] ?? null;
$equalTo = $_GET['equalTo'] ?? null;
$greaterField = $_GET['greaterField'] ?? null;
$greaterValue = $_GET['greaterValue'] ?? null;
$limit = $_GET['limit'] ?? null;

$response = new GetController();

// echo isset($_GET['rel']) . '<br>';
// echo isset($_GET['type']) . '<br>';
// echo $table . '<br>';
// echo isset($_GET['linkTo']) . '<br>';
// echo isset($_GET['equalTo']) . '<br>';
// return;
if (isset($_GET['linkTo']) && isset($_GET['equalTo']) && !isset($_GET['sum']) && !isset($_GET['rel']) && !isset($_GET['type'])) {
    //peticion GET con filtro    
    $response->getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt, $limit, $greaterField, $greaterValue);
} else if (isset($_GET['rel']) && isset($_GET['type']) && $table == "relations" && !isset($_GET['linkTo']) && !isset($_GET['equalTo']) && !isset($_GET['filterTo'])) {
    //echo '2';
    //peticion GET relacionadas sin filtro
    $response->getRelData($_GET['rel'], $_GET['type'], $select, $orderBy, $orderMode, $startAt, $endAt, $distinct);
} else if (isset($_GET['rel']) && isset($_GET['type']) && $table == "relations" && isset($_GET['linkTo']) && isset($_GET['equalTo'])) {
    //peticion GET relacionadas con filtro    
    $response->getRelDataFilter($_GET['rel'], $_GET['type'], $select, $orderBy, $orderMode, $startAt, $endAt, $_GET['linkTo'], $_GET['equalTo'], $groupBy);
} else if (!isset($_GET['rel']) && !isset($_GET['type']) && isset($_GET['linkTo']) && isset($_GET['serch'])) {
    //peticion GET serch
    $response->getDataSerch($table, $select, $_GET['linkTo'], $_GET['serch'], $orderBy, $orderMode, $startAt, $endAt);
} else if (isset($_GET['rel']) && isset($_GET['type']) && !isset($_GET['field']) && $table == "relations" && isset($_GET['linkTo']) && isset($_GET['serch']) && !isset($_GET['on'])) {
    //peticion GET buscador relacionadas sin filtro
    $response->getRelDataSerch($_GET['rel'], $_GET['type'], $select, $orderBy, $orderMode, $startAt, $endAt, $_GET['linkTo'], $_GET['serch']);
} else if (isset($_GET['rel']) && isset($_GET['on']) && $table == "relations") {
    //peticion GET buscador relacionadas con sum
    //    echo 'entró';
    //     exit; 
    $response->getRelDataGroup($_GET['rel'], $_GET['on'], $select, $groupBy);
} else if (!isset($_GET['rel']) && !isset($_GET['type']) && isset($_GET['linkTo']) && isset($_GET['between1']) && isset($_GET['between2'])) {
    //peticion GET seleccion de rangos
    $response->getDataRange($table, $select, $orderBy, $orderMode, $startAt, $endAt, $_GET['linkTo'], $_GET['between1'], $_GET['between2'], $filterTo, $inTo);
} else if (isset($_GET['rel']) && isset($_GET['type']) && !isset($_GET['field']) && $table == "relations" && isset($_GET['linkTo']) && isset($_GET['between1']) && isset($_GET['between2'])) {
    //peticion GET seleccion de rangos con tablas relacionadas
    $response->getRelDataRange($_GET['rel'], $_GET['type'], $select, $orderBy, $orderMode, $startAt, $endAt, $_GET['linkTo'], $_GET['between1'], $_GET['between2'], $filterTo, $inTo);
} else if (isset($_GET['rel']) && isset($_GET['type']) && $table == "relations" && isset($_GET['filterTo']) && isset($_GET['inTo']) && !isset($_GET['between1'])) {
    //peticion GET IN con tablas relacionadas   
    $response->getRelIn($_GET['rel'], $_GET['type'], $select, $orderBy, $orderMode, $startAt, $endAt, $filterTo, $inTo);
} else if (!isset($_GET['rel']) && isset($_GET['type']) && isset($_GET['serch']) && isset($_GET['linkTo']) && isset($_GET['between1']) && isset($_GET['between2'])) {
    $response->getIdDataRange($table, $select, $_GET['type'], $_GET['serch'], $orderBy, $orderMode, $startAt, $endAt, $linkTo, $_GET['between1'], $_GET['between2'], $filterTo, $inTo);
} else if (isset($_GET['rel']) && isset($_GET['type']) && isset($_GET['serch']) && isset($_GET['linkTo']) && isset($_GET['between1']) && isset($_GET['between2']) && isset($_GET['field'])) {
    $response->getIdRelDataRange($table, $select, $_GET['rel'], $_GET['type'], $_GET['serch'], $_GET['field'], $orderBy, $orderMode, $startAt, $endAt, $linkTo, $_GET['between1'], $_GET['between2'], $filterTo, $inTo);
} else if (isset($_GET['sum']) && isset($_GET['orderBy'])) {
    //peticion GET IN con tablas relacionadas   
    $response->getRelIn($_GET['rel'], $_GET['type'], $select, $orderBy, $orderMode, $startAt, $endAt, $filterTo, $inTo);
} else if (isset($_GET['sum']) && isset($_GET['groupBy'])) {
    //peticion GET SUM    
    $response->getDataSum($table, $select, $sum, $groupBy,  $linkTo, $equalTo);
} else {
    //peticion GET sin filtro
    $response->getData($table, $select, $orderBy, $orderMode, $startAt, $endAt);
}
