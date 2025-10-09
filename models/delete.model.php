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
    static public function deleteDataGeneric($table, $id, $nameId)
    {

        $sql = "DELETE from $table WHERE $nameId = :$nameId";

        //$link = Connection::connect();
        $stmt = self::$link->prepare($sql);
        $stmt->bindParam(":" . $nameId, $id, PDO::PARAM_STR);
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
    static public function deleteDataSuministro($table, $idSuministro)
    {
        $sql = "DELETE from $table WHERE id_suministro = :id_suministro";
        $stmt = self::$link->prepare($sql);
        $stmt->bindParam(':id_suministro', $idSuministro, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $rowCount = $stmt->rowCount();
            $response = array(
                "status" => "200",
                "result" => $rowCount > 0 ? "Eliminación exitosa ($rowCount filas afectadas)" : "No se eliminó ningún registro",
                "rows_affected" => $rowCount
            );
            return $response;
        } else {
            $errorInfo = $stmt->errorInfo();
            return array(
                "status" => "500",
                "result" => "Error en la eliminación: " . $errorInfo[2]
            );
        }
    }
    static public function deleteDataLote($table, $idLote)
    {
        $sql = "DELETE from $table WHERE id_lote = $idLote";

        //$link = Connection::connect();
        $stmt = self::$link->prepare($sql);
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
