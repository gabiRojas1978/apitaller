<?php

$routesArray = explode('/', $_SERVER['REQUEST_URI']);
$routesArray = array_filter($routesArray);

if (count($routesArray) == 0) {
    $json = array(
        'status' => '404',
        'result' => 'Not Found'
    );
} else {
    if (isset($_SERVER['REQUEST_METHOD'])) {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            include "services/get.php";
        }
        if ($_SERVER['REQUEST_METHOD'] == "PUT") {
            include "services/put.php";
        }
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            include "services/post.php";
        }
        if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
            include "services/delete.php";
        }
    }
}

return;







// use App\Core\Route;
// use App\Controller\HomeController;

// $route = new Route;
// $route::get('/', [HomeController::class, 'index']);
// $route::get('about', [HomeController::class, 'about']);
// //run
// $route::run();
