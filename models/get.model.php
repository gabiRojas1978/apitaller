<?php

//require_once "connection.php";

class GetModel
{
    static private $link;

    // Método para establecer la conexión
    static public function setConnection($connection)
    {
        self::$link = $connection;
    }

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
        $stmt = self::$link->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    //peticion GET sin filtro tablas relacionadas
    static public function getRelData($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt, $distinct)
    {
        $relToArray = explode(',', $rel);
        $typeToArray = explode(',', $type);
        $innerJoinText = '';

        if (count($relToArray) > 1) {
            foreach ($relToArray as $key => $value) {
                if ($key > 0) {
                    //$innerJoinText .= " INNER JOIN " . $value . " ON " . $relToArray[0] . ".id_" . $typeToArray[$key] . "_" . $typeToArray[0] . "=" . $value . ".id_" . $typeToArray[$key] . " ";
                    $innerJoinText .= " INNER JOIN " . $value . " ON " . $relToArray[0] . ".id_" . $typeToArray[0] . "=" . $value . ".id_" . $typeToArray[$key] . " ";
                }
            }

            $sql = "SELECT $select FROM $relToArray[0] $innerJoinText ";
            if ($orderBy != null) {
                $sql .= " ORDER BY $orderBy $orderMode";
            }
            if ($startAt != null && $endAt != null) {
                $sql .= " LIMIT $startAt, $endAt";
            }

            //echo $sql;
            $stmt = self::$link->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } else {
            return null;
        }
    }

    //peticion GET con filtro tablas relacionadas
    static public function getRelDataFilter($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $equalTo, $groupBy = null)
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
                    //$innerJoinText .= " INNER JOIN " . $value . " ON " . $relToArray[0] . ".id_" . $typeToArray[$key] . "_" . $typeToArray[0] . "=" . $value . ".id_" . $typeToArray[$key] . " ";
                    $innerJoinText .= " INNER JOIN " . $value . " ON " . $relToArray[0] . ".id_" . $typeToArray[0] . "=" . $value . ".id_" . $typeToArray[$key] . " ";
                }
            }


            $sql = "SELECT $select FROM $relToArray[0] $innerJoinText where $linkToArray[0] = :$linkToArray[0] $linkToParams";
            if ($orderBy != null) {
                $sql .= " ORDER BY $orderBy $orderMode";
            }
            if ($startAt != null && $endAt != null) {
                $sql .= " LIMIT $startAt, $endAt";
            }
            if ($groupBy) {
                $sql .= " GROUP BY $groupBy";
            }
            //echo $sql;
            $stmt = self::$link->prepare($sql);
            foreach ($linkToArray as $key => $value) {
                $stmt->bindParam(':' . $value, $equalToArray[$key], PDO::PARAM_STR);
            }
            $stmt->execute();
            //print_r($stmt->fetchAll(PDO::FETCH_CLASS));
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } else {
            return null;
        }
    }

    //peticion GET con filtro tablas relacionadas
    static public function getRelDataFilterChain($fromAndJoins, $select, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $equalTo, $groupBy = null)
    {
        $sql = "SELECT $select FROM $fromAndJoins";

        // Solo agregar WHERE si linkTo y equalTo están definidos
        if ($linkTo != null && $equalTo != null) {
            $sql .= " WHERE $linkTo = :link";
        }

        if ($orderBy != null) {
            $sql .= " ORDER BY $orderBy $orderMode";
        }
        if ($startAt != null && $endAt != null) {
            $sql .= " LIMIT $startAt, $endAt";
        }
        if ($groupBy) {
            $sql .= " GROUP BY $groupBy";
        }

        $stmt = self::$link->prepare($sql);

        // Solo bindear si hay WHERE
        if ($linkTo != null && $equalTo != null) {
            $param = is_numeric($equalTo) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $stmt->bindParam(':link', $equalTo, $param);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    //peticion GET con filtro
    static public function getDataFilterGreater($table, $select, $orderBy = null, $orderMode = null, $startAt = null, $endAt = null, $limit = null, $greaterField = null, $greaterValue = null, $field = null, $search = null)
    {

        if (($field !== null && $search !== null)) {
            $and = " AND $field = $search ";
        } else {
            $and = "";
        }

        $sql = "SELECT $select FROM  $table where  $greaterField > $greaterValue" . $and;

        if ($orderBy != null) {
            $sql .= " ORDER BY $orderBy $orderMode";
        }
        if ($startAt != null && $endAt != null) {
            $sql .= " LIMIT $startAt, $endAt";
        }
        if ($limit != null) {
            $sql .= " LIMIT $limit";
        }
        $stmt = self::$link->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }


    //peticion GET con filtro
    static public function getDataFilter($table, $select, $linkTo, $equalTo, $orderBy = null, $orderMode = null, $startAt = null, $endAt = null, $limit = null, $greaterField = null, $greaterValue = null)
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
        if ($greaterField !== null && $greaterValue !== null) {
            $sql .= " AND $greaterField > $greaterValue ";
        }
        if ($orderBy != null) {
            $sql .= " ORDER BY $orderBy $orderMode";
        }
        if ($startAt != null && $endAt != null) {
            $sql .= " LIMIT $startAt, $endAt";
        }
        if ($limit != null) {
            $sql .= " LIMIT $limit";
        }
        $stmt = self::$link->prepare($sql);
        foreach ($linkToArray as $key => $value) {
            $stmt->bindParam(':' . $value, $equalToArray[$key], PDO::PARAM_STR);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function getDatasearch($table, $select, $linkTo, $search, $orderBy, $orderMode, $startAt, $endAt)
    {
        $linkToArray = explode(',', $linkTo);
        $searchToArray = explode(',', $search);
        $linkToParams = '';
        if (count($linkToArray) > 1) {
            foreach ($linkToArray as $key => $value) {
                if ($key > 0) {
                    $linkToParams .= 'and ' . $value . '=:' . $value . " ";
                }
            }
        }
        $sql = "SELECT $select FROM $table where $linkToArray[0] like '%$searchToArray[0]%' $linkToParams ";
        if ($orderBy != null) {
            $sql .= " ORDER BY $orderBy $orderMode";
        }
        if ($startAt != null && $endAt != null) {
            $sql .= " LIMIT $startAt, $endAt";
        }
        //print_r($sql);
        $stmt = self::$link->prepare($sql);
        foreach ($linkToArray as $key => $value) {
            if ($key > 0) {
                $stmt->bindParam(':' . $value, $searchToArray[$key], PDO::PARAM_STR);
            }
        }
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }
    //peticion GET busqueda con filtro tablas relacionadas
    static public function getRelDatasearch($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $search, $having, $havingValue)
    {
        //filtros
        $linkToArray = explode(',', $linkTo);
        $searchToArray = explode(',', $search);
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
                    $innerJoinText .= " LEFT JOIN " . $value . " ON " .
                        $relToArray[0] . ".id_" . $typeToArray[0] . " = " .
                        $value . ".id_" . $typeToArray[$key] . " ";
                }
            }

            $sql = "SELECT $select FROM $relToArray[0] $innerJoinText where $linkToArray[0] like '%$searchToArray[0]%' $linkToParams ";
            if ($orderBy != null) {
                $sql .= " ORDER BY $orderBy $orderMode";
            }
            if ($startAt != null && $endAt != null) {
                $sql .= " LIMIT $startAt, $endAt";
            }
            if ($having) {
                $sql .= " HAVING $having > '$havingValue' ";
            }
            //echo $sql;
            $stmt = self::$link->prepare($sql);
            foreach ($linkToArray as $key => $value) {
                if ($key > 0) {
                    $stmt->bindParam(':' . $value, $searchToArray[$key], PDO::PARAM_STR);
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
        $stmt = self::$link->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function getIdDataRange($table, $select, $type, $search, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $between1, $between2, $filterTo, $inTo)
    {
        $filter = "";
        if ($filterTo != null && $inTo != null) {
            $filter = "and " . $filterTo . " IN ($inTo) ";
        }
        $sql = "SELECT $select FROM $table WHERE $type=$search and $linkTo BETWEEN '$between1' AND '$between2'" . $filter;
        if ($orderBy != null) {
            $sql .= " ORDER BY $orderBy $orderMode";
        }
        if ($startAt != null && $endAt != null) {
            $sql .= " LIMIT $startAt, $endAt";
        }
        $stmt = self::$link->prepare($sql);
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
                    $innerJoinText .= " INNER JOIN " . $value . " ON " . $relToArray[0] . ".id_" .  $typeToArray[0] . "=" . $value . ".id_" . $typeToArray[$key] . " ";
                }
            }

            $sql = "SELECT $select FROM $relToArray[0] $innerJoinText WHERE date($linkTo) BETWEEN '$between1' AND '$between2'" . $filter;
            if ($orderBy != null) {
                $sql .= " ORDER BY $orderBy $orderMode";
            }
            if ($startAt != null && $endAt != null) {
                $sql .= " LIMIT $startAt, $endAt";
            }
            //echo $sql;
            $stmt = self::$link->prepare($sql);
            $stmt->execute();
            //print_r($stmt->fetchAll(PDO::FETCH_CLASS));
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } else {
            return null;
        }
    }

    static public function getRelDatasearchGreater($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt, $field, $search, $greaterField, $greaterValue)
    {
        $relToArray = explode(',', $rel);
        $typeToArray = explode(',', $type);
        $innerJoinText = '';
        if (count($relToArray) > 1) {
            foreach ($relToArray as $key => $value) {
                if ($key > 0) {
                    $innerJoinText .= " INNER JOIN " . $value . " ON " . $relToArray[0] . ".id_"  . $typeToArray[0] . "=" . $value . ".id_" . $typeToArray[$key] . " ";
                }
            }

            $sql = "SELECT $select FROM $relToArray[0] $innerJoinText WHERE $field=$search and " . $greaterField . " > " . $greaterValue;
            //echo $sql;
            if ($orderBy != null) {
                $sql .= " ORDER BY $orderBy $orderMode";
            }
            if ($startAt != null && $endAt != null) {
                $sql .= " LIMIT $startAt, $endAt";
            }
            $stmt = self::$link->prepare($sql);
            $stmt->execute();
        } else {
            return null;
        }
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function getIdRelDataRange($table, $select, $rel, $type, $search, $field, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $between1, $between2, $filterTo, $inTo)
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
                    $innerJoinText .= " INNER JOIN " . $value . " ON " . $relToArray[0] . ".id_"  . $typeToArray[0] . "=" . $value . ".id_" . $typeToArray[$key] . " ";
                }
            }

            $sql = "SELECT $select FROM $relToArray[0] $innerJoinText WHERE $field=$search and date($linkTo) BETWEEN '$between1' AND '$between2'" . $filter;

            if ($orderBy != null) {
                $sql .= " ORDER BY $orderBy $orderMode";
            }
            if ($startAt != null && $endAt != null) {
                $sql .= " LIMIT $startAt, $endAt";
            }
            //echo $sql;
            $stmt = self::$link->prepare($sql);
            $stmt->execute();
        } else {
            return null;
        }

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function getRelIn($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt, $filterTo, $inTo)
    {

        $filter = "";
        if ($filterTo != null && $inTo != null) {
            // Convertir $inTo en un array si no lo es
            if (!is_array($inTo)) {
                $inTo = explode(',', $inTo); // Asumimos que viene como una cadena separada por comas
            }

            // Colocar los placeholders para la cláusula IN
            $placeholders = implode(',', array_fill(0, count($inTo), '?'));

            $filter = $filterTo . " IN ($placeholders)";
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
            //echo $filter;

            $sql = "SELECT $select FROM $relToArray[0] $innerJoinText WHERE " . $filter;
            if ($orderBy != null) {
                $sql .= " ORDER BY $orderBy $orderMode";
            }
            if ($startAt != null && $endAt != null) {
                $sql .= " LIMIT $startAt, $endAt";
            }
            $stmt = $stmt = self::$link->prepare($sql);
            // Bindear los valores a los placeholders
            foreach ($inTo as $key => $value) {
                // Detectar si es número o texto
                if (is_numeric($value)) {
                    $stmt->bindValue(($key + 1), $value, PDO::PARAM_INT);
                } else {
                    $stmt->bindValue(($key + 1), $value, PDO::PARAM_STR);
                }
            }
            $stmt->execute();
        } else {
            return null;
        }

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    //peticion GET SUM
    static public function getDataSum($table, $select, $sum, $groupBy,  $linkTo, $equalTo)
    {

        $sql = "SELECT $select, SUM($sum) as total FROM $table";
        if ($linkTo != null && $equalTo != null) {
            $sql .= " WHERE $linkTo = $equalTo";
        }
        if ($groupBy != null) {
            $sql .= " GROUP BY $groupBy";
        }
        //echo $sql;
        $stmt = self::$link->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    //sum con relations
    static public function getRelDataGroup(
        $rel,
        $type,
        $select,
        $groupBy,
        $field,
        $search,
        $orderBy = null,
        $orderMode = null,
        $startAt = null,
        $endAt = null,
        $where = null,
        $having = null,
        $havingValue = null
    ) {
        $relToArray = explode(',', $rel);
        $typeToArray = explode(',', $type);
        $innerJoinText = '';

        if (count($relToArray) > 1) {
            foreach ($relToArray as $key => $value) {
                if ($key > 0) {
                    $innerJoinText .= " INNER JOIN " . $value .
                        " ON id_" . $typeToArray[0] .
                        "= id_" . $typeToArray[$key] . " ";
                }
            }
        }

        $sql = "SELECT $select FROM " . $relToArray[0] . $innerJoinText;
        if ($field && $search) {
            $sql .= " WHERE $field = '$search' ";
        }

        if ($groupBy) {
            $sql .= " GROUP BY $groupBy";
        }
        if ($orderBy) {
            $sql .= " ORDER BY $orderBy";
            if ($orderMode) {
                $sql .= " $orderMode";
            }
        }
        if ($startAt !== null && $endAt !== null) {
            $sql .= " LIMIT $startAt, $endAt";
        }
        if ($having) {
            $sql .= " HAVING $having > '$havingValue' ";
        }
        //echo $sql;
        $stmt = self::$link->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
