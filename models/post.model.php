<?php
require_once "connection.php";

class PostModel
{
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
        // print_r($columns);
        // echo "<br>";
        // print_r($params);
        // echo "<br>";
        // return;
        $link = Connection::connect();
        $stmt = $link->prepare($sql);
        foreach ($data  as $key => $value) {
            $stmt->bindParam(":" . $key, $data[$key], PDO::PARAM_STR);
        }
        if ($stmt->execute()) {
            $response = array(
                "lastId" => $link->lastInsertId(),
                "result" => "Carga exitosa"
            );
            return $response;
        } else {
            return $link->errorInfo();
        }
    }
}
