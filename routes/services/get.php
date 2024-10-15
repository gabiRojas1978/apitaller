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
    $linkTo = $_GET['linkTo'];
    $equalTo = $_GET['equalTo'];
    $response->getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt);
} else if (isset($_GET['rel']) && isset($_GET['type']) && $table == "relations" && !isset($_GET['linkTo']) && !isset($_GET['equalTo'])) {
    $response->getRelData($_GET['rel'], $_GET['type'], $select, $orderBy, $orderMode, $startAt, $endAt);
} else if (isset($_GET['rel']) && isset($_GET['type']) && $table == "relations" && isset($_GET['linkTo']) && isset($_GET['equalTo'])) {
    $response->getRelDataFilter($_GET['rel'], $_GET['type'], $select, $orderBy, $orderMode, $startAt, $endAt, $_GET['linkTo'], $_GET['equalTo']);
} else if (!isset($_GET['rel']) && !isset($_GET['type']) && isset($_GET['linkTo']) && isset($_GET['serch'])) {
    $response->getDataSerch($table, $select, $_GET['linkTo'], $_GET['serch'], $orderBy, $orderMode, $startAt, $endAt);
} else if (isset($_GET['rel']) && isset($_GET['type']) && $table == "relations" && isset($_GET['linkTo']) && isset($_GET['serch'])) {
    $response->getRelDataSerch($_GET['rel'], $_GET['type'], $select, $orderBy, $orderMode, $startAt, $endAt, $_GET['linkTo'], $_GET['serch']);
} else if (!isset($_GET['rel']) && !isset($_GET['type']) && isset($_GET['linkTo']) && isset($_GET['between1']) && isset($_GET['between2'])) {
    $response->getDataRange($table, $select, $orderBy, $orderMode, $startAt, $endAt, $_GET['linkTo'], $_GET['between1'], $_GET['between2'], $filterTo, $inTo);
} else if (isset($_GET['rel']) && isset($_GET['type']) && $table == "relations" && isset($_GET['linkTo']) && isset($_GET['between1']) && isset($_GET['between2'])) {
    $response->getRelDataRange($_GET['rel'], $_GET['type'], $select, $orderBy, $orderMode, $startAt, $endAt, $_GET['linkTo'], $_GET['between1'], $_GET['between2'], $filterTo, $inTo);
} else {
    $response->getData($table, $select, $orderBy, $orderMode, $startAt, $endAt);
}
