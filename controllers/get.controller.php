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
    static public function getRelData($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt)
    {
        $response = GetModel::getRelData($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt);

        $return = new GetController();
        $return->fncResponse($response);
    }

    //peticion GET relacionadas sin filtro
    static public function getRelDataFilter($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $equalTo)
    {
        $response = GetModel::getRelDataFIlter($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $equalTo);

        $return = new GetController();
        $return->fncResponse($response);
    }

    //peticion GET con filtro
    static public function getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt)
    {
        $response = GetModel::getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt);
        $return = new GetController();
        $return->fncResponse($response);
    }

    //peticion GET serch
    static public function getDataSerch($table, $select, $linkTo, $serch, $orderBy, $orderMode, $startAt, $endAt)
    {
        $response = GetModel::getDataSerch($table, $select, $linkTo, $serch, $orderBy, $orderMode, $startAt, $endAt);
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
                'results' => 'Not Found'
            );
        }
        echo json_encode($json, http_response_code($json['status']));
    }

    //peticion GET buscador relacionadas sin filtro
    static public function getRelDataSerch($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $serch)
    {
        $response = GetModel::getRelDataSerch($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $serch);

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

    //peticion GET seleccion de rangos con tablas relacionadas
    static public function getRelDataRange($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $between1, $between2, $filterTo, $inTo)
    {
        $response = GetModel::getRelDataRange($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt, $linkTo, $between1, $between2, $filterTo, $inTo);

        $return = new GetController();
        $return->fncResponse($response);
    }
}
