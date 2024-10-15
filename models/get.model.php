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

    //peticion GET sin filtro tablas relacionadas
    static public function getRelData($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt)
    {
        $relToArray = explode(',', $rel);
        $typeToArray = explode(',', $type);
        $innerJoinText = '';
        if (count($relToArray) > 1) {
            foreach ($relToArray as $key => $value) {
                if ($key > 0) {
                    $innerJoinText .= " INNER JOIN " . $value . " ON " . $relToArray[0] . ".id_" . $typeToArray[$key] . "_" . $typeToArray[0] . "=" . $value . ".id_" . $typeToArray[$key] . " ";
                }
            }


            $sql = "SELECT $select FROM $relToArray[0] $innerJoinText ";
            if ($orderBy != null) {
                $sql .= " ORDER BY $orderBy $orderMode";
            }
            if ($startAt != null && $endAt != null) {
                $sql .= " LIMIT $startAt, $endAt";
            }
            $stmt = Connection::connect()->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } else {
            return null;
        }
    }

    //peticion GET con filtro tablas relacionadas
    static public function getRelDataFilter($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $equalTo)
    {
        //filtros
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

        //relaciones
        $relToArray = explode(',', $rel);
        $typeToArray = explode(',', $type);
        $innerJoinText = '';
        if (count($relToArray) > 1) {
            foreach ($relToArray as $key => $value) {
                if ($key > 0) {
                    $innerJoinText .= " INNER JOIN " . $value . " ON " . $relToArray[0] . ".id_" . $typeToArray[$key] . "_" . $typeToArray[0] . "=" . $value . ".id_" . $typeToArray[$key] . " ";
                }
            }


            $sql = "SELECT $select FROM $relToArray[0] $innerJoinText where $linkToArray[0] = :$linkToArray[0] $linkToParams";
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
        } else {
            return null;
        }
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

    static public function getDataSerch($table, $select, $linkTo, $serch, $orderBy, $orderMode, $startAt, $endAt)
    {
        $linkToArray = explode(',', $linkTo);
        $serchToArray = explode(',', $serch);
        $linkToParams = '';
        if (count($linkToArray) > 1) {
            foreach ($linkToArray as $key => $value) {
                if ($key > 0) {
                    $linkToParams .= 'and ' . $value . '=:' . $value . " ";
                }
            }
        }
        $sql = "SELECT $select FROM $table where $linkToArray[0] like '%$serchToArray[0]%' $linkToParams ";
        if ($orderBy != null) {
            $sql .= " ORDER BY $orderBy $orderMode";
        }
        if ($startAt != null && $endAt != null) {
            $sql .= " LIMIT $startAt, $endAt";
        }
        $stmt = Connection::connect()->prepare($sql);
        foreach ($linkToArray as $key => $value) {
            if ($key > 0) {
                $stmt->bindParam(':' . $value, $serchToArray[$key], PDO::PARAM_STR);
            }
        }
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }
    //peticion GET busqueda con filtro tablas relacionadas
    static public function getRelDataSerch($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $serch)
    {
        //filtros
        $linkToArray = explode(',', $linkTo);
        $serchToArray = explode(',', $serch);
        $linkToParams = '';
        if (count($linkToArray) > 1) {
            foreach ($linkToArray as $key => $value) {
                if ($key > 0) {
                    $linkToParams .= 'and ' . $value . '=:' . $value . " ";
                }
            }
        }

        //relaciones
        $relToArray = explode(',', $rel);
        $typeToArray = explode(',', $type);
        $innerJoinText = '';
        if (count($relToArray) > 1) {
            foreach ($relToArray as $key => $value) {
                if ($key > 0) {
                    $innerJoinText .= " INNER JOIN " . $value . " ON " . $relToArray[0] . ".id_" . $typeToArray[$key] . "_" . $typeToArray[0] . "=" . $value . ".id_" . $typeToArray[$key] . " ";
                }
            }


            $sql = "SELECT $select FROM $relToArray[0] $innerJoinText where $linkToArray[0] like '%$serchToArray[0]%' $linkToParams ";
            if ($orderBy != null) {
                $sql .= " ORDER BY $orderBy $orderMode";
            }
            if ($startAt != null && $endAt != null) {
                $sql .= " LIMIT $startAt, $endAt";
            }


            $stmt = Connection::connect()->prepare($sql);
            foreach ($linkToArray as $key => $value) {
                if ($key > 0) {
                    $stmt->bindParam(':' . $value, $serchToArray[$key], PDO::PARAM_STR);
                }
            }
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } else {
            return null;
        }
    }

    //peticion GET seleccion de rangos
    static public function getDataRange($table, $select, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $between1, $between2, $filterTo, $inTo)
    {
        $filter = "";
        if ($filterTo != null && $inTo != null) {
            $filter = "and " . $filterTo . " IN ($inTo) ";
        }
        $sql = "SELECT $select FROM $table WHERE $linkTo BETWEEN '$between1' AND '$between2'" . $filter;
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

    //peticion GET seleccion de rangos con relaciones
    static public function getRelDataRange($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $between1, $between2, $filterTo, $inTo)
    {

        $filter = "";
        if ($filterTo != null && $inTo != null) {
            $filter = "and " . $filterTo . " IN ($inTo) ";
        }

        $relToArray = explode(',', $rel);
        $typeToArray = explode(',', $type);
        $innerJoinText = '';
        if (count($relToArray) > 1) {
            foreach ($relToArray as $key => $value) {
                if ($key > 0) {
                    $innerJoinText .= " INNER JOIN " . $value . " ON " . $relToArray[0] . ".id_" . $typeToArray[$key] . "_" . $typeToArray[0] . "=" . $value . ".id_" . $typeToArray[$key] . " ";
                }
            }

            $sql = "SELECT $select FROM $relToArray[0] $innerJoinText WHERE $linkTo BETWEEN '$between1' AND '$between2'" . $filter;
            if ($orderBy != null) {
                $sql .= " ORDER BY $orderBy $orderMode";
            }
            if ($startAt != null && $endAt != null) {
                $sql .= " LIMIT $startAt, $endAt";
            }
            $stmt = Connection::connect()->prepare($sql);
            $stmt->execute();
        } else {
            return null;
        }

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }
}
