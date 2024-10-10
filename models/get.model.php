<?php

require_once "connection.php";

class GetModel
{

    //peticion GET sin filtro
    static public function getData($table, $select, $orderBy, $orderMode, $startAt, $endAt)
    {
        $sql = "SELECT $select FROM " . $table;
        if ($orderBy != null) {
            $sql .= " ORDER BY $orderBy $orderMode";
        }
        if ($startAt != null && $endAt != null) {
            $sql .= " LIMIT $startAt, $endAt";
        }
        $stmt = Connection::connect()->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    //peticion GET con filtro
    static public function getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt)
    {
        $linkToArray = explode(',', $linkTo);
        $equalToArray = explode(',', $equalTo);
        $linkToParams = '';
        if (count($linkToArray) > 1) {
            foreach ($linkToArray as $key => $value) {
                if ($key > 0) {
                    $linkToParams .= 'and ' . $value . '=:' . $value . " ";
                }
            }
        }
        $sql = "SELECT $select FROM  $table where $linkToArray[0] = :$linkToArray[0] $linkToParams";
        if ($orderBy != null) {
            $sql .= " ORDER BY $orderBy $orderMode";
        }
        if ($startAt != null && $endAt != null) {
            $sql .= " LIMIT $startAt, $endAt";
        }
        $stmt = Connection::connect()->prepare($sql);
        foreach ($linkToArray as $key => $value) {
            $stmt->bindParam(':' . $value, $equalToArray[$key], PDO::PARAM_STR);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }
}
