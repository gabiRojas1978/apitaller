<?php

require_once "models/delete.model.php";

class DeleteController
{

    static public function deleteDataGeneric($table, $id, $nameId)
    {
        $response = deleteModel::deleteDataGeneric($table, $id, $nameId);
        $return = new DeleteController();
        $return->fncResponse($response);
    }
    static public function deleteData($table, $id, $idSE, $nameId, $nameIdSE)
    {
        $response = deleteModel::deleteData($table, $id, $idSE, $nameId, $nameIdSE);
        $return = new DeleteController();
        $return->fncResponse($response);
    }
    static public function deleteDataSuministro($table, $idSuministro)
    {
        $response = deleteModel::deleteDataSuministro($table, $idSuministro);
        $return = new DeleteController();
        $return->fncResponse($response);
    }
    static public function deleteDataLote($table, $idLote)
    {
        $response = deleteModel::deleteDataLote($table, $idLote);
        $return = new DeleteController();
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
}
