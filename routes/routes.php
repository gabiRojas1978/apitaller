<?php

$routesArray = explode('/', $_SERVER['REQUEST_URI']);
$routesArray = array_filter($routesArray);

if (count($routesArray) == 0) {
    $json = array(
        'status' => '200',
        'result' => 'Bienvenido a la api de Talleres Ortiz'
    );
    echo json_encode($json, http_response_code($json['status']));
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
