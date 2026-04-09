<?php
require_once "models/get.model.php";
class GetController
{
    //peticion GET sin filtro
    static public function getData($table, $select, $orderBy, $orderMode, $startAt, $endAt)
    {
        $response = GetModel::getData($table, $select, $orderBy, $orderMode, $startAt, $endAt);
        $return = new GetController();
        $return->fncResponse($response);
    }

    //peticion GET relacionadas sin filtro
    static public function getRelData($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt, $distinct)
    {
        $response = GetModel::getRelData($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt, $distinct);

        $return = new GetController();
        $return->fncResponse($response);
    }

    //peticion GET relacionadas con filtro
    static public function getRelDataFilter($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $equalTo, $groupBy = null)
    {
        $response = GetModel::getRelDataFilter($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $equalTo, $groupBy);

        $return = new GetController();
        $return->fncResponse($response);
    }

    static public function getRelDataFilterChain($fromAndJoins, $select, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $equalTo, $groupBy = null)
    {
        $response = GetModel::getRelDataFilterChain($fromAndJoins, $select, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $equalTo, $groupBy);

        $return = new GetController();
        $return->fncResponse($response);
    }

    //peticion GET con filtro
    static public function getDataFilterGreater($table, $select, $orderBy, $orderMode, $startAt, $endAt, $limit = null, $greaterField = null, $greaterValue = null, $field = null, $search = null)
    {
        $response = GetModel::getDataFilterGreater($table, $select, $orderBy, $orderMode, $startAt, $endAt, $limit, $greaterField, $greaterValue, $field, $search);
        $return = new GetController();
        $return->fncResponse($response);
    }
    //peticion GET con filtro
    static public function getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt, $limit = null, $greaterField = null, $greaterValue = null)
    {
        $response = GetModel::getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt, $limit, $greaterField, $greaterValue);
        $return = new GetController();
        $return->fncResponse($response);
    }

    //peticion GET search
    static public function getDatasearch($table, $select, $linkTo, $search, $orderBy, $orderMode, $startAt, $endAt)
    {
        $response = GetModel::getDatasearch($table, $select, $linkTo, $search, $orderBy, $orderMode, $startAt, $endAt);
        $return = new GetController();
        $return->fncResponse($response);
    }

    //peticion GET buscador relacionadas sin filtro
    static public function getRelDatasearch($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $search, $having = null, $havingValue = null)
    {
        $response = GetModel::getRelDatasearch($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $search, $having, $havingValue);

        $return = new GetController();
        $return->fncResponse($response);
    }

    //peticion GET seleccion de rangos
    static public function getDataRange($table, $select, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $between1, $between2, $filterTo, $inTo)
    {
        $response = GetModel::getDataRange($table, $select, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $between1, $between2, $filterTo, $inTo);

        $return = new GetController();
        $return->fncResponse($response);
    }

    static public function getIdDataRange($table, $select, $type, $search, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $between1, $between2, $filterTo, $inTo)
    {
        $response = GetModel::getIdDataRange($table, $select, $type, $search, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $between1, $between2, $filterTo, $inTo);

        $return = new GetController();
        $return->fncResponse($response);
    }

    static public function getRelDatasearchGreater($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt, $field, $search, $greaterField, $greaterValue)
    {
        $response = GetModel::getRelDatasearchGreater($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt, $field, $search, $greaterField, $greaterValue);

        $return = new GetController();
        $return->fncResponse($response);
    }

    static public function getIdRelDataRange($table, $select, $rel, $type, $search, $field, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $between1, $between2, $filterTo, $inTo)
    {
        $response = GetModel::getIdRelDataRange($table, $select, $rel, $type, $search, $field, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $between1, $between2, $filterTo, $inTo);

        $return = new GetController();
        $return->fncResponse($response);
    }

    //peticion GET seleccion de rangos con tablas relacionadas
    static public function getRelDataRange($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $between1, $between2, $filterTo, $inTo)
    {
        $response = GetModel::getRelDataRange($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $between1, $between2, $filterTo, $inTo);

        $return = new GetController();
        $return->fncResponse($response);
    }

    //peticion GET IN con tablas relacionadas
    static public function getRelIn($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt, $filterTo, $inTo)
    {
        $response = GetModel::getRelIn($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt, $filterTo, $inTo);

        $return = new GetController();
        $return->fncResponse($response);
    }

    //peticion GET SUM
    static public function getDataSum($table, $select, $sum, $groupBy,  $linkTo, $equalTo)
    {
        $response = GetModel::getDataSum($table, $select, $sum, $groupBy,  $linkTo, $equalTo);

        $return = new GetController();
        $return->fncResponse($response);
    }

    //peticion GET SUM
    static public function getRelDataGroup(
        $rel,
        $type,
        $select,
        $groupBy,
        $field,
        $search,
        $orderBy,
        $orderMode,
        $startAt,
        $endAt,
        $where,
        $having,
        $havingValue
    ) {
        $response = GetModel::getRelDataGroup(
            $rel,
            $type,
            $select,
            $groupBy,
            $field,
            $search,
            $orderBy,
            $orderMode,
            $startAt,
            $endAt,
            $where,
            $having,
            $havingValue
        );

        $return = new GetController();
        $return->fncResponse($response);
    }

    public function fncResponse($response)
    {
        if (!empty($response)) {
            $json = array(
                'status' => 200,
                'results' => $response
            );
        } else {
            $json = array(
                'status' => 404,
                'results' => 'Not Found',
                "Method" => "POST",
                'response' => $response
            );
        }
        echo json_encode($json, http_response_code($json['status']));
    }
}
