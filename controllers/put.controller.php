<?php

require_once "models/put.model.php";

class putController
{

    static public function putData($table, $data, $id, $nameId)
    {
        $response = putModel::putData($table, $data, $id, $nameId);
        $return = new putController();
        $return->fncResponse($response);
    }

    static public function putDataSet($table, $set, $id, $nameId)
    {
        //echo "hola";
        $response = putModel::putDataSet($table, $set, $id, $nameId);
        $return = new putController();
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
        //echo "hola";
    }
}
