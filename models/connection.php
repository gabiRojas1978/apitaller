<?php

class Connection
{
    static public function infoDatabase()
    {
        $infoDB = array(
            "database" => "taller",
            "host" => "localhost",
            "username" => "root",
            "password" => ""
        );

        return $infoDB;
    }

    static public function connect()
    {
        try {
            $link = new PDO(
                "mysql:host=" . Connection::infoDatabase()['host'] . ";dbname=" . Connection::infoDatabase()['database'],
                Connection::infoDatabase()['username'],
                Connection::infoDatabase()['password']
            );
            $link->exec("set names utf8");
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return $link;
    }
}
