<?php

    class Response {
        public static $msg = '';
        public static $statusCode = 422; // Variable para almacenar codigo http global segun indique el origen.
        public static $message = NULL; // Variable para almacenar mensajes globales del sistema y acceder desde cualquier parte.
        public static $from = 'undefined'; // Variable globales para almacenar origen de respuesta, se puede acceder desde cualquier parte.

        public static function JsonV1($data, $base64 = false){
            $data = json_decode(json_encode($data));
            $response = [
                'CODE'=>http_response_code(),
                'MESSAGE'=>self::$msg,
                'METHOD'=>$_SERVER['REQUEST_METHOD'],
                'URI_ENTRYPOINT'=>$_SERVER['REQUEST_URI'],
                'response'=> $data
            ];

            if(is_string($data)){
                $data = ['MESSAGE'=> $data];
            }

            if(!isset($data->CODE)){
                $response['response'] = [
                    'CODE'=>http_response_code(),
                    'METHOD'=>$_SERVER['REQUEST_METHOD'],
                    'data'=>$data,
                ];
            }

            $data = json_encode($response);

            if($base64){
                echo base64_encode(json_encode($data));
                die;
            }

            echo $data;
            die;
        }

        public static function json($data = [], $responseType = false){
            if(empty($data) OR is_null($data)){
                $data = self::$message;
            }

            if(is_object($data)){
                $data = get_object_vars($data);
            }

            $error = Request::getKey($data,'error');
            unset($data['error']);

            if($responseType == 'json'){
                $data = json_encode($data);
            }

            $response = [
                'code'=>http_response_code(),
                'code_msg'=>Http::getCodeMSJ(http_response_code()),
                'method'=>$_SERVER['REQUEST_METHOD'],
                'uri_entrypoint'=>$_SERVER['REQUEST_URI'],
                'error'=>$error,
                'results'=> $data
            ];

            $response = json_encode($response);

            if($responseType == 'base64'){
                $response = base64_encode($response);
            }

            echo $response;
            die;
        }

        public static function err($err = NULL, $message = '', $org = ''){
            Http::Err($err, $message, $org);
            die;
        }

        public static function Image($img, $base64 = false){
            /*
                En la variable $img, se espera una ruta http o local para extraer la imagen.
            */

            $img = file_get_contents($img);
            if($img){
                if($base64){
                    $img = base64_encode($img);
                }

                return $img;
                die;
            }

            return NULL;
            die;
        }

        public static function prohibited($origin = ''){
            $incidentcode = Token::Create(25);
            Logs::Server("RESTRICTED_AREA | INCIDENT_CODE: $incidentcode | $origin");
            Http::Err(403,"RESTRICTED_AREA", "$origin | INCIDENT_CODE: $incidentcode");
            die;
        }
        public static function unauthorized($origin = ''){
            $incidentcode = Token::Create(25);
            Logs::Server("WITHOUT_SUFFICIENT_PERMISSION | INCIDENT_CODE: $incidentcode | $origin");
            Http::Err(401,"WITHOUT_SUFFICIENT_PERMISSION", "$origin | INCIDENT_CODE: $incidentcode");
            die;
        }
    }
