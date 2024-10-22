<?php
require_once "controllers/post.controller.php";
$table = explode("?", $routesArray[1])[0];

$response = new PostController();

//registro de usuarios
if (isset($_GET['register']) && $_GET['register'] == true) {
    $response->postRegister($table, $_POST);
} else if (isset($_GET['login']) && $_GET['login'] == true) {
    $response->postLogin($table, $_POST);
} else {
    $response->postData($table, $_POST);
}
