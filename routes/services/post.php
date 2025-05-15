<?php
require_once "controllers/post.controller.php";
require_once "models/connection.php";

$table = explode("?", $routesArray[1])[0];

$response = new PostController();

if (isset($_GET['register']) && $_GET['register'] == true) {    //registro de usuarios 
    $response->postRegister($table, $_POST);
    return;
} else if (isset($_GET['login']) && $_GET['login'] == true) {
    //login de usuarios  
    $response->postLogin($table, $_POST);
} else {
    //resto de los post     
    $response->postData($table, $_POST);
}
