<?php

require_once "get.model.php";
class Connection
{
    static public function infoDatabase($database)
    {
        $infoDB = array(
            "database" => $database,
            "host" => "localhost",
            "username" => "root",
            "password" => ""
        );
        return $infoDB;
    }

    static public function connect($database)
    {
        try {
            $link = new PDO(
                "mysql:host=" . Connection::infoDatabase($database)['host'] . ";dbname=" . Connection::infoDatabase($database)['database'],
                Connection::infoDatabase($database)['username'],
                Connection::infoDatabase($database)['password']
            );
            $link->exec("set names utf8");
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
