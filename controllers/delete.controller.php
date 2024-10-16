<?php

require_once "models/delete.model.php";

class DeleteController
{

    static public function deleteData($table, $id, $nameId)
    {
        $response = deleteModel::deleteData($table, $id, $nameId);
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
