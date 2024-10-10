<?php

$host = 'localhost';
$dbname = 'taller';
$username = 'root';
$password = '';

try {
    // Crear una nueva instancia de PDO para la conexión a la base de datos
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Configurar PDO para que lance excepciones en caso de error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Establecer el modo de devolución de los resultados a asociativo
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Establecer el conjunto de caracteres a UTF-8
    $pdo->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    // Manejar el error de conexión
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
