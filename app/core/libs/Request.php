<?php

    class Request{
        public static $params = NULL; // Variable para alacenar la respuesta, se establece en "vacio" con cada interaccion.
        protected static $bool = false; // Variable para alacenar la respuesta, se establece en "vacio" con cada interaccion.

        public static function Inputs(){
            $contents = json_decode(file_get_contents('php://input'));

            if(is_null($contents)){
                $contents = json_decode('{}');
            }

            return $contents;
        }

        public static function Required($array = NULL, $keys=[], $origin =''){
            /* 
                El metodo self::Required(), espera dos argumentos de tipo array y un string.
                $array, es el array de entrada donde se buscaran las claves definidas en el segundo array nombrado $keys.
                $keys, son los nombres de las claves a ser buscadas y retornadas en la respuesta self::$params
                Este método, almacena los datos encontrados según los índices dentro de $keys, en la variable self::$params.
                Retornar true o false; según coincidencias.
                $origin, es un parametro opcional que sirve para indicar desde donde se produce la peticion del metodo.

                Para que se retorne true, los índices deben existir y contener datos.

                Ej:
                    Request::Required(['username'=>'jonh', 'password'=>''123456], ['username','password'])
            */

            if(is_null($array) OR empty($array)){
                $incidentcode = Token::generate(25);
                Alerts::Server('DATA_REQUIRED_TO_CONTINUE -> The $array variable is mandatory, it cannot be empty or null. | INCIDENT_CODE: '.$incidentcode.' | '.__METHOD__.':'.__LINE__);
                Http::Err(203,['DATA_REQUIRED_TO_CONTINUE' => [
                    'incident'=>'The $array variable is mandatory, it cannot be empty or null.',
                    'incident_code'=> $incidentcode
                ],$origin.' '.__METHOD__.':'.__LINE__]);
            }
            if(is_null($keys) OR empty($keys)){
                $incidentcode = Token::generate(25);
                Alerts::Server('DATA_REQUIRED_TO_CONTINUE -> The array $keys variable is mandatory, it cannot be empty or null. | INCIDENT_CODE: '.$incidentcode.' | '.__METHOD__.':'.__LINE__);
                Http::Err(203,['DATA_REQUIRED_TO_CONTINUE'=> [
                    'incident'=>'The array $keys variable is mandatory, it cannot be empty or null.',
                    'incident_code'=> $incidentcode
                ],$origin.' '.__METHOD__.':'.__LINE__ ]);
            }

            $array = json_decode(json_encode($array));
            $keys = json_decode(json_encode($keys));
            $data = [];
            if(!empty($origin)){
                $origin = $origin ." | ";
            }

            if(!empty($keys)){
                foreach($keys as $key){
                    if(!property_exists($array, $key) OR empty($array->$key)){
                        $incidentcode = Token::generate(25);
                        Alerts::Server('DATA_REQUIRED_TO_CONTINUE -> The parameter '.$key.', is empty or does not exist. | INCIDENT_CODE: '.$incidentcode.' | '.__METHOD__.':'.__LINE__);
                        Http::Err(203,['DATA_REQUIRED_TO_CONTINUE' => [
                            'incident'=>"The parameter '$key', is empty or does not exist.",
                            'incident_code'=> $incidentcode
                        ]],$origin.__METHOD__.':'.__LINE__ );
                        die;
                    }
    
                    self::$params[$key] = $array->$key;
                    $data[$key] = $array->$key;
                }
            }


            return $data;
            return true;
        }

        public static function Post($required = [], $response = NULL){
            /*
                Se esperan dos argumentos, uno del tipo array y otro string.
                $required, define los parametros a buscar y retornar, los cuales se evaluaran usando el metodo privado self::Required.
                $response, define el tipo de respuesta, si un array simple o codificado en json, texto o xml.

                Ej:
                    Request::Post(['username', 'password'], 'json')
            */
            if($response == 'bool'){
                self::$bool = true;
            }
            if(isset($_POST)){
                if(!empty($required)){
                    if(!self::Required($_POST, $required)){
                        return false;
                        die;
                    }
                }

                if(!is_null($response)){
                    if($response == 'json'){
                        return Response::Json($_POST);
                        unset($_POST);
                        die;
                    }
                }

                return self::$params;
                return $_POST;
                die;
            }

            return false;
            die;
        }

        public static function Get($keys = [], $require = false){
            if(isset($_GET)){                
                if(!empty($keys)){
                    if(!$require){
                        return false;
                        die;
                    }
                }

                if(is_string($keys)){
                    return $_GET[$keys];
                }

                return $_GET[$keys[0]];
            }
        }

        public static function reload($method = ''){
            if($method == 'POST' OR $method == 'post'){
                unset($_POST);
            }elseif($method == 'GET' OR $method == 'get'){
                unset($_GET);
            }elseif($method == 'FILE'){
                unset($_FILES);
            }else{
                unset($_POST, $_GET, $_FILES);
            }
        }

        public static function Keys($array = [], $implode = false){
            if(!empty($array)){
                foreach($array as $key => $value){
                    $keys[] = "$key";
                }
                if($implode){
                    $keys = implode(',', $keys);
                }

                return $keys;
            }

            return false;
        }

        public static function Key($array = [], $keys = [], $origin =''){
            $array = json_decode(json_encode($array));
            $keys = json_decode(json_encode($keys));

            foreach($keys as $key){
                if(!property_exists($array, $key) OR empty($array->$key)){
                    $incidentcode = Token::generate(25);
                    Alerts::Server('203_DATA_REQUIRED_TO_CONTINUE ->'.$key.' | INCIDENT_CODE: '.$incidentcode.' | '.__METHOD__.':'.__LINE__);
                    Http::Err(203,['DATA_REQUIRED_TO_CONTINUE'=>[
                        'incident_code'=> $incidentcode,
                        "incident"=>"Value required: $key | INCIDENT_CODE: $incidentcode",
                    ],$origin.' '.__METHOD__.':'.__LINE__ ]);
                }

                return self::$params[$key] = $array->$key;
            }
        }

        public static function getKey($array, string $key, $origin = '')
        {
            if (empty($array)) {
                return false;
            }
    
            if (is_object($array)) {
                $array = get_object_vars($array); //json_decode(json_encode($array));
            }
    
            if (!is_array($array)) {
                return false;
            }
    
            if (key_exists($key, $array) and !empty($array[$key])) {
                if($key == 'columns'){
                    $array[$key] = str_replace(' ', '', $array[$key]);
                }
                return self::$params[$key] = $array[$key];
            }
    
            return false;
        }

        public static function getKeys($array, array $keys, $origin =''){
            // Validación inicial del tipo de dato
            if(empty($array)) {
                Alerts::Server("Empty array provided. | $origin");
                return false;
            }

            if(is_object($array)){
                $array = get_object_vars($array);
            } elseif(!is_array($array)) {
                Alerts::Server("Invalid data type. Array or object expected. | $origin");
                return false;
            }

            foreach($keys as $key){
                if(!array_key_exists($key, $array) || empty($array[$key])){
                    Alerts::Server("Param key $key, not found or empty. | $origin");
                    return false;
                }

                self::$params[$key] = $array[$key];
            }
            
            return self::$params;
        }

        public static function getColumns($array, $origin =''){
            $key = 'columns';
            $value = is_array($array) ? $array[$key] ?? null : (is_object($array) ? $array->{$key} ?? null : null);

            if (!empty($value)) {
                $value = str_replace(' ', '', $value);
                return self::$params[$key] = $value;
            }

            return false;
        }

        public static function getLimit($array, $origin =''){
            $key = 'limit';
            $value = is_array($array) ? $array[$key] ?? null : (is_object($array) ? $array->{$key} ?? null : null);

            if (!empty($value)) {
                $value = str_replace(' ', '', $value);
                if(is_int($value)){
                    return self::$params[$key] = $value;
                }
            }

            return false;
        }

        public static function Clean($str, $array){
            $array = json_decode(json_encode($array));
            if(isset($array->$str) AND !empty($array->$str)){
                if(isset($array->$str)){
                    if(!empty($array->$str)){
                        $str = htmlspecialchars($array->$str);
                        return $str;
                        die;
                    }
                }
            }

            return 'UNDEFINED';
        }

        public static function File($name = NULL){
            if(isset($_FILES) AND !is_null($name)){
                if(!isset($_FILES[$name])){
                    return false;
                    die;
                }
                return $_FILES[$name];
                //App::Debug($_FILES[$name]);
            }else{
                return false;
                die;
            }
        }
    }
