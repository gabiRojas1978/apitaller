<?php
require_once "controllers/post.controller.php";
$table = explode("?", $routesArray[1])[0];

$response = new PostController();
$response->postData($table, $_POST);
