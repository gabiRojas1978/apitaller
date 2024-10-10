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
            $json = array(
                'status' => '200',
                'result' => 'PUT request received'
            );
            echo json_encode($json, http_response_code($json['status']));
        }
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $json = array(
                'status' => '200',
                'result' => 'POST request received'
            );
            echo json_encode($json, http_response_code($json['status']));
        }
        if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
            $json = array(
                'status' => '200',
                'result' => 'DELETE request received'
            );
            echo json_encode($json, http_response_code($json['status']));
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
