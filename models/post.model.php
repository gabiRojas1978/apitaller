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
            $stmt->bindParam(":" . $key, $data[$key], PDO::PARAM_STR);
        }
        if ($stmt->execute()) {
            try {
                $lastId = self::$link->lastInsertId();
            } catch (Exception $e) {
                $lastId = 0;
            }
            $response = array(
                "lastId" => $lastId,
                "result" => "Carga exitosa"
            );
            return $response;
        } else {
            //return self::$link->errorInfo();
            return array(
                "lastId" => null,
                "result" => "Error en la carga: " . $stmt->errorInfo()
            );
        }
    }
}
