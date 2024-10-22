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


$response = new GetController();

// echo isset($_GET['rel']) . '<br>';
// echo isset($_GET['type']) . '<br>';
// echo $table . '<br>';
// echo isset($_GET['linkTo']) . '<br>';
// echo isset($_GET['equalTo']) . '<br>';
// return;


if (isset($_GET['linkTo']) && isset($_GET['equalTo']) && !isset($_GET['rel']) && !isset($_GET['type'])) {
    //peticion GET con filtro
    $linkTo = $_GET['linkTo'];
    $equalTo = $_GET['equalTo'];
    $response->getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt);
} else if (isset($_GET['rel']) && isset($_GET['type']) && $table == "relations" && !isset($_GET['linkTo']) && !isset($_GET['equalTo']) && !isset($_GET['filterTo'])) {
    echo '2';
    //peticion GET relacionadas sin filtro
    $response->getRelData($_GET['rel'], $_GET['type'], $select, $orderBy, $orderMode, $startAt, $endAt);
} else if (isset($_GET['rel']) && isset($_GET['type']) && $table == "relations" && isset($_GET['linkTo']) && isset($_GET['equalTo'])) {
    //peticion GET relacionadas con filtro
    $response->getRelDataFilter($_GET['rel'], $_GET['type'], $select, $orderBy, $orderMode, $startAt, $endAt, $_GET['linkTo'], $_GET['equalTo']);
} else if (!isset($_GET['rel']) && !isset($_GET['type']) && isset($_GET['linkTo']) && isset($_GET['serch'])) {
    //peticion GET serch
    $response->getDataSerch($table, $select, $_GET['linkTo'], $_GET['serch'], $orderBy, $orderMode, $startAt, $endAt);
} else if (isset($_GET['rel']) && isset($_GET['type']) && $table == "relations" && isset($_GET['linkTo']) && isset($_GET['serch'])) {
    //peticion GET buscador relacionadas sin filtro
    $response->getRelDataSerch($_GET['rel'], $_GET['type'], $select, $orderBy, $orderMode, $startAt, $endAt, $_GET['linkTo'], $_GET['serch']);
} else if (!isset($_GET['rel']) && !isset($_GET['type']) && isset($_GET['linkTo']) && isset($_GET['between1']) && isset($_GET['between2'])) {
    //peticion GET seleccion de rangos
    $response->getDataRange($table, $select, $orderBy, $orderMode, $startAt, $endAt, $_GET['linkTo'], $_GET['between1'], $_GET['between2'], $filterTo, $inTo);
} else if (isset($_GET['rel']) && isset($_GET['type']) && $table == "relations" && isset($_GET['linkTo']) && isset($_GET['between1']) && isset($_GET['between2'])) {
    //peticion GET seleccion de rangos con tablas relacionadas
    $response->getRelDataRange($_GET['rel'], $_GET['type'], $select, $orderBy, $orderMode, $startAt, $endAt, $_GET['linkTo'], $_GET['between1'], $_GET['between2'], $filterTo, $inTo);
} else if (isset($_GET['rel']) && isset($_GET['type']) && $table == "relations" && isset($_GET['filterTo']) && isset($_GET['inTo']) && !isset($_GET['between1'])) {
    //peticion GET IN con tablas relacionadas
    echo 'getRelIn';
    $response->getRelIn($_GET['rel'], $_GET['type'], $select, $orderBy, $orderMode, $startAt, $endAt, $filterTo, $inTo);
} else {
    //peticion GET sin filtro
    $response->getData($table, $select, $orderBy, $orderMode, $startAt, $endAt);
}
