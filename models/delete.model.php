<?php
//require_once "connection.php";

class DeleteModel
{
    static private $link;

    // Método para establecer la conexión
    static public function setConnection($connection)
    {
        self::$link = $connection;
    }
    static public function deleteData($table, $id, $idSE, $nameId, $nameIdSE)
    {

        $sql = "DELETE from $table WHERE $nameId = :$nameId AND $nameIdSE = :$nameIdSE";

        //$link = Connection::connect();
        $stmt = self::$link->prepare($sql);
        $stmt->bindParam(":" . $nameId, $id, PDO::PARAM_STR);
        $stmt->bindParam(":" . $nameIdSE, $idSE, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $response = array(
                "status" => "200",
                "result" => "Eliminación exitosa"
            );
            return $response;
        } else {
            return self::$link->errorInfo();
        }
    }
}
