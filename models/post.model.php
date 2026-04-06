<?php
//require_once "connection.php";

class PostModel
{
    static private $link;

    // Método para establecer la conexión
    static public function setConnection($connection)
    {
        self::$link = $connection;
    }
    static public function postData($table, $data)
    {
        $columns = "";
        $params = "";

        foreach ($data as $key => $value) {
            $columns .= $key . ",";
            $params .= ":" . $key . ",";
        }

        $columns = substr($columns, 0, -1);
        $params = substr($params, 0, -1);
        $sql = "INSERT INTO  $table  ($columns) VALUES ($params)";
        $stmt = self::$link->prepare($sql);
        foreach ($data  as $key => $value) {
            //$stmt->bindParam(":" . $key, $data[$key], PDO::PARAM_STR);
            $stmt->bindValue(":" . $key, $value, PDO::PARAM_STR);
        }
        $result = $stmt->execute();
        if ($result) {
            try {
                $lastId = self::$link->lastInsertId();
            } catch (Exception $e) {
                $lastId = 0;
            }
            $response = array(
                "lastId" => $lastId,
                "result" => "Carga exitosa",
                "data" => $result
            );
            return $response;
        } else {
            $errorInfo = $stmt->errorInfo();
            return array(
                "lastId" => 0,
                "result" => "Error en la carga",
                "error" => $errorInfo[2], // Mensaje de error de la base de datos
                "data" => $result
            );
        }
    }
}
