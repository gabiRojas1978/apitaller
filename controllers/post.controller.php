<?php

require_once "models/post.model.php";
require_once "models/get.model.php";
require_once "models/connection.php";
require_once "models/put.model.php";
require_once "vendor/autoload.php";

use Firebase\JWT\JWT;

class PostController
{

    static public function postData($table, $data)
    {
        $response = PostModel::postData($table, $data);
        $return = new PostController();
        $return->fncResponse($response);
    }

    static public function postRegister($table, $data)
    {
        $suffix = $data['suffix'] ?? "usuario";

        if (isset($data['pass_' . $suffix]) && $data['pass_' . $suffix] != null) {
            $crypt = crypt($data['pass_' . $suffix], '$2a$07$loryfhndgctewisyr5847dfc2$');
            $data['pass_' . $suffix] = $crypt;

            $response = PostModel::postData($table, $data);
            $return = new PostController();
            $return->fncResponse($response);
        }
    }
    static public function postLogin($table, $data)
    {
        $suffix = $data['suffix'] ?? "usuario";
        //validar que usuario exista
        $response = GetModel::getDataFilter($table, "*", "nombre_" . $suffix, $data['nombre_' . $suffix], null, null, null, null);
        if (!empty($response)) {
            $crypt = crypt($data['pass_' . $suffix], '$2a$07$loryfhndgctewisyr5847dfc2$');
            if ($response[0]->{"pass_" . $suffix} == $crypt) {
                //$token = Connection::jwt($response[0]->{"id_" . $suffix}, $response[0]->{"nombre_" . $suffix});
                $payload = [
                    "sub" => $response[0]->{"id_" . $suffix},           // ID del usuario
                    "nombre" => $response[0]->{"nombre_" . $suffix},    // Nombre
                    "rol" => $response[0]->{"rol"} ?? "usuario",        // Rol (opcional)
                    "iat" => date('Y-m-d H:i:s', time()),                                    // Emitido en
                    "exp" => date('Y-m-d H:i:s', time() + (3600 * 24 * 7))                   // Expira en 7 días
                ];
                $jwt = JWT::encode($payload, 'tokenjwttoken', "HS256");
                //actualizar token usuario
                $data = array(
                    "token_" . $suffix => $jwt,
                    "token_exp_" . $suffix => $payload["exp"],
                );
                $update = PutModel::putData($table, $data, $response[0]->{"id_" . $suffix}, "id_" . $suffix);

                if ($update["result"]) {
                    $response = array(
                        'nombre' => $response[0]->{"nombre_" . $suffix},
                        'rol' => $response[0]->{"rol_" . $suffix},
                        'token' => $jwt,
                        'id' => $response[0]->{"id_" . $suffix},
                    );
                }
            } else {
                $response = null;
            }
        } else {
            $response = null;
        }
        $return = new PostController();
        $return->fncResponse($response);
    }

    public function fncResponse($response)
    {
        $response = $response ?? null;
        if (!empty($response)) {
            $json = array(
                'status' => 200,
                'results' => $response
            );
        } else {
            $json = array(
                'status' => 404,
                'results' => $response
            );
        }
        http_response_code($json['status']);
        echo json_encode($json);
    }
}
