<?php
require_once "controllers/get.controller.php";
$table = ! empty($routesArray)
    ? (explode("?", end($routesArray))[0] ?? null)
    : null;
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
$field = $_GET['field'] ?? null;
$search = $_GET['search'] ?? null;
$limit = $_GET['limit'] ?? null;
$where = $_GET['where'] ?? null;
$having = $_GET['having'] ?? null;
$havingValue = $_GET['havingvalue'] ?? null;
$response = new GetController();

// debug helpers removed

if (isset($_GET['linkTo']) && isset($_GET['equalTo']) && !isset($_GET['sum']) && !isset($_GET['rel']) && !isset($_GET['type']) && !isset($_GET['fromAndJoins'])) {
    //peticion GET con filtro     
    $response->getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt, $limit, $greaterField, $greaterValue);
} else if (!isset($_GET['linkTo']) && !isset($_GET['equalTo']) && !isset($_GET['sum']) && !isset($_GET['rel']) && !isset($_GET['type']) && isset($_GET['greaterField'])) {
    //peticion GET con field y greaterField   
    $response->getDataFilterGreater($table, $select, $orderBy, $orderMode, $startAt, $endAt, $limit, $greaterField, $greaterValue, $field, $search);
} else if (isset($_GET['rel']) && isset($_GET['type']) && $table == "relations" && isset($_GET['field']) && isset($_GET['search']) && isset($_GET['greaterField']) && !isset($_GET['between1'])) {
    //peticion GET relacionadas con search, field y greaterField
    $response->getRelDatasearchGreater($_GET['rel'], $_GET['type'], $select, $orderBy, $orderMode, $startAt, $endAt,  $_GET['field'], $_GET['search'], $_GET['greaterField'], $_GET['greaterValue']);
} else if (isset($_GET['rel']) && isset($_GET['type']) && $table == "relations" && !isset($_GET['linkTo']) && !isset($_GET['equalTo']) && !isset($_GET['filterTo'])) {
    //echo '2';
    //peticion GET relacionadas sin filtro
    $response->getRelData($_GET['rel'], $_GET['type'], $select, $orderBy, $orderMode, $startAt, $endAt, $distinct);
} else if (isset($_GET['rel']) && isset($_GET['type']) && $table == "relations" && isset($_GET['linkTo']) && isset($_GET['equalTo'])) {
    //peticion GET relacionadas con filtro  
    //echo '3';
    $response->getRelDataFilter($_GET['rel'], $_GET['type'], $select, $orderBy, $orderMode, $startAt, $endAt, $_GET['linkTo'], $_GET['equalTo'], $groupBy);
} else if (!isset($_GET['rel']) && !isset($_GET['type']) && isset($_GET['linkTo']) && isset($_GET['search'])) {
    //peticion GET search
    $response->getDatasearch($table, $select, $_GET['linkTo'], $_GET['search'], $orderBy, $orderMode, $startAt, $endAt);
} else if (isset($_GET['rel']) && isset($_GET['type']) && !isset($_GET['field']) && $table == "relations" && isset($_GET['linkTo']) && isset($_GET['search']) && !isset($_GET['on'])) {
    //peticion GET buscador relacionadas sin filtro
    //echo '4';
    $response->getRelDatasearch($_GET['rel'], $_GET['type'], $select, $orderBy, $orderMode, $startAt, $endAt, $_GET['linkTo'], $_GET['search'], $having, $havingValue);
} else if (isset($_GET['rel']) && isset($_GET['on']) && $table == "relations") {
    //peticion GET buscador relacionadas con sum
    // echo '5';
    //     exit; 
    $response->getRelDataGroup($_GET['rel'], $_GET['on'], $select, $groupBy, $field, $search, $orderBy, $orderMode, $startAt, $endAt, $where, $having, $havingValue);
} else if (!isset($_GET['rel']) && !isset($_GET['type']) && isset($_GET['linkTo']) && isset($_GET['between1']) && isset($_GET['between2'])) {
    //peticion GET seleccion de rangos
    $response->getDataRange($table, $select, $orderBy, $orderMode, $startAt, $endAt, $_GET['linkTo'], $_GET['between1'], $_GET['between2'], $filterTo, $inTo);
} else if (isset($_GET['rel']) && isset($_GET['type']) && !isset($_GET['field']) && $table == "relations" && isset($_GET['linkTo']) && isset($_GET['between1']) && isset($_GET['between2'])) {
    //peticion GET seleccion de rangos con tablas relacionadas
    //echo '6';
    $response->getRelDataRange($_GET['rel'], $_GET['type'], $select, $orderBy, $orderMode, $startAt, $endAt, $_GET['linkTo'], $_GET['between1'], $_GET['between2'], $filterTo, $inTo);
} else if (isset($_GET['rel']) && isset($_GET['type']) && $table == "relations" && isset($_GET['filterTo']) && isset($_GET['inTo']) && !isset($_GET['between1'])) {
    //peticion GET IN con tablas relacionadas   
    //echo '7';
    $response->getRelIn($_GET['rel'], $_GET['type'], $select, $orderBy, $orderMode, $startAt, $endAt, $filterTo, $inTo);
} else if (!isset($_GET['rel']) && isset($_GET['type']) && isset($_GET['search']) && isset($_GET['linkTo']) && isset($_GET['between1']) && isset($_GET['between2'])) {
    $response->getIdDataRange($table, $select, $_GET['type'], $_GET['search'], $orderBy, $orderMode, $startAt, $endAt, $linkTo, $_GET['between1'], $_GET['between2'], $filterTo, $inTo);
} else if (isset($_GET['rel']) && isset($_GET['type']) && isset($_GET['search']) && isset($_GET['linkTo']) && isset($_GET['between1']) && isset($_GET['between2']) && isset($_GET['field'])) {
    //echo '9';
    $response->getIdRelDataRange($table, $select, $_GET['rel'], $_GET['type'], $_GET['search'], $_GET['field'], $orderBy, $orderMode, $startAt, $endAt, $linkTo, $_GET['between1'], $_GET['between2'], $filterTo, $inTo);
} else if (isset($_GET['sum']) && isset($_GET['orderBy'])) {
    //peticion GET IN con tablas relacionadas   
    $response->getRelIn($_GET['rel'], $_GET['type'], $select, $orderBy, $orderMode, $startAt, $endAt, $filterTo, $inTo);
} else if (isset($_GET['sum']) && isset($_GET['groupBy'])) {
    //peticion GET SUM    
    $response->getDataSum($table, $select, $sum, $groupBy,  $linkTo, $equalTo);
} else if (isset($_GET['fromAndJoins'])) {
    //peticion GET con join personalizado
    $response->getRelDataFilterChain($_GET['fromAndJoins'], $select, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $equalTo, $groupBy);
} else {
    //echo 'por defecto';
    //peticion GET sin filtro    
    $response->getData($table, $select, $orderBy, $orderMode, $startAt, $endAt);
}
