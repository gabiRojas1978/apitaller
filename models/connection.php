<?php

require_once "get.model.php";
class Connection
{
    static public function infoDatabase($database)
    {
        $infoDB = array(
            "database" => $database,
            "host" => "127.0.0.1",
            "username" => "root",
            "password" => ""
        );
        return $infoDB;
    }

    static public function connect($database)
    {
        try {
            $info = Connection::infoDatabase($database);
            $link = new PDO(
                "mysql:host={$info['host']};dbname={$info['database']};charset=utf8",
                $info['username'],
                $info['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_PERSISTENT => false,
                    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
                ]
            );
            //$link->exec("set names utf8");
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return $link;
    }

    //token de validación
    static public function jwt($id, $nombre_usuario)
    {
        $time = time();

        $exp_time = date('Y-m-d H:i:s', $time + (60 * 60 * 8));

        $token = array(
            "iat" => $time,
            "exp" => $exp_time,
            "data" => [
                "id" => $id,
                "nombre" => $nombre_usuario
            ]
        );

        return $token;
    }

    static public function tokenValidate($token)
    {
        $tokenUser = GetModel::getDataFilter("usuarios", "token_exp_usuario", "token_usuario", $token);
        $ahora = date('Y-m-d H:i:s', time());
        if (!empty($tokenUser) && $ahora < $tokenUser[0]->token_exp_usuario) {
            return true;
        } else {
            return false;
        }
    }
}
