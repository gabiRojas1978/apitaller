<?php

class Usuario
{
    private $pdo;

    public function __construct()
    {
        require '../config/config.php'; // Incluye la conexión a la base de datos
        $this->pdo = $pdo;
    }

    public function getUsuarios()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
