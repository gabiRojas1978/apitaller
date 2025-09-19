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
        //print_r($sql);
        $stmt = self::$link->prepare($sql);
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
                    $innerJoinText .= " INNER JOIN " . $value . " ON " .
                        $relToArray[0] . ".id_" . $typeToArray[0] . " = " .
                        $value . ".id_" . $typeToArray[$key] . " ";
                }
            }


            $sql = "SELECT $select FROM $relToArray[0] $innerJoinText where $linkToArray[0] like '%$serchToArray[0]%' $linkToParams ";
            if ($orderBy != null) {
                $sql .= " ORDER BY $orderBy $orderMode";
            }
            if ($startAt != null && $endAt != null) {
                $sql .= " LIMIT $startAt, $endAt";
            }

            //echo $sql;
            $stmt = self::$link->prepare($sql);
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
        $stmt = self::$link->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function getIdDataRange($table, $select, $type, $serch, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $between1, $between2, $filterTo, $inTo)
    {
        $filter = "";
        if ($filterTo != null && $inTo != null) {
            $filter = "and " . $filterTo . " IN ($inTo) ";
        }
        $sql = "SELECT $select FROM $table WHERE $type=$serch and $linkTo BETWEEN '$between1' AND '$between2'" . $filter;
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
                    $innerJoinText .= " INNER JOIN " . $value . " ON " . $relToArray[0] . ".id_" . $typeToArray[$key] . "_" . $typeToArray[0] . "=" . $value . ".id_" . $typeToArray[$key] . " ";
                }
            }

            $sql = "SELECT $select FROM $relToArray[0] $innerJoinText WHERE date($linkTo) BETWEEN '$between1' AND '$between2'" . $filter;
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

    static public function getIdRelDataRange($table, $select, $rel, $type, $serch, $field, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $between1, $between2, $filterTo, $inTo)
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

            $sql = "SELECT $select FROM $relToArray[0] $innerJoinText WHERE $field=$serch and date($linkTo) BETWEEN '$between1' AND '$between2'" . $filter;

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
            echo $filter;

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
        $rel,           // Ej: "lotes,productos"
        $type,          // Ej: "lote,producto"
        $select,        // Ej: "lotes.codigo_lote, productos.nombre_producto, SUM(lotes.cantidad_lote) AS total_cantidad"
        $groupBy,       // Ej: "lotes.codigo_lote, productos.nombre_producto"
        $orderBy = null,
        $orderMode = null,
        $startAt = null,
        $endAt = null,
        $where = null   // Ej: "lotes.estado = 1"
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
        if ($where) {
            $sql .= " WHERE $where";
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

        $stmt = self::$link->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
