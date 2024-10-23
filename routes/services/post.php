<?php
require_once "controllers/post.controller.php";
require_once "models/connection.php";
$table = explode("?", $routesArray[1])[0];


$response = new PostController();

if (isset($_GET['register']) && $_GET['register'] == true) {
    //registro de usuarios
    if (isset($_GET['token'])) {
        if (Connection::tokenValidate($_GET['token'])) {
            $response->postData($table, $_POST);
        } else {
            echo 'token incorrecto o expirado';
            return;
        }
    } else {
        echo 'Error: Peticion sin token';
        return;
    }
    $response->postRegister($table, $_POST);
} else if (isset($_GET['login']) && $_GET['login'] == true) {
    //login de usuarios  
    $response->postLogin($table, $_POST);
} else {
    //resto de los post 
    if (isset($_GET['token'])) {
        if (Connection::tokenValidate($_GET['token'])) {
            $response->postData($table, $_POST);
        } else {
            echo 'token incorrecto o expirado';
            return;
        }
    } else {
        echo 'Error: Peticion sin token';
        return;
    }
}
