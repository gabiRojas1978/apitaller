<?php
require_once "controllers/post.controller.php";


$response = new PostController();
$response->postData($table, $_POST);
