<?php
require_once "connection.php";

class DeleteModel
{
    static public function deleteData($table, $id, $nameId)
    {

        $sql = "DELETE from $table WHERE $nameId = :$nameId";

        $link = Connection::connect();
        $stmt = $link->prepare($sql);
        $stmt->bindParam(":" . $nameId, $id, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $response = array(
                "result" => "Eliminación exitosa"
            );
            return $response;
        } else {
            return $link->errorInfo();
        }
    }
}
