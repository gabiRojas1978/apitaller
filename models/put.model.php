<?php
//require_once "connection.php";

class PutModel
{
    static private $link;

    // Método para establecer la conexión
    static public function setConnection($connection)
    {
        self::$link = $connection;
    }
    static public function putData($table, $data, $id, $nameId)
    {
        $suffix = $data['suffix'] ?? "usuario";

        if (isset($data['pass_' . $suffix]) && $data['pass_' . $suffix] != null) {
            $crypt = crypt($data['pass_' . $suffix], '$2a$07$loryfhndgctewisyr5847dfc2$');
            $data['pass_' . $suffix] = $crypt;
        }
        $set = "";
        foreach ($data as $key => $value) {

            $set .= $key . " = :" . $key . ",";
        }

        $set = substr($set, 0, -1);
        $sql = "UPDATE $table SET $set WHERE $nameId = :$nameId";
        //$link = Connection::connect();
        $stmt = self::$link->prepare($sql);
        foreach ($data  as $key => $value) {
            $stmt->bindParam(":" . $key, $data[$key], PDO::PARAM_STR);
        }
        $stmt->bindParam(":" . $nameId, $id, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $response = array(
                "Comment" => "Modificación exitosa",
                "result" => true
            );
            return $response;
        } else {
            return self::$link->errorInfo();
        }
    }
}
