<?php

class Get
{
    public static function Model($rute = 'none', $data = [])
    {
        $file = ROOTDIR . 'models/' . $rute . 'Model.php';

        if (!file_exists($file)) {
            Alerts::Server("Error: Could not load model $file. " . __METHOD__ . ':' . __LINE__);
            Http::Err(500, "File model, not found or could not be loaded. Report to Technical Support.", __METHOD__ . ':' . __LINE__);
            die;
        }

        $arg = explode('/', $rute);
        $name = isset($arg[1]) ? $arg[1] . 'Model' : $rute . 'Model';
        $class_payload = NULL;
        if (!class_exists($name)) {
            extract($data);
            require_once $file;

            if (!class_exists($name)) {
                //Si no existe la clase, se envia error 500 y se informa a soporte del error.
                Alerts::Server("Error: Could not load model $name. " . __METHOD__ . ':' . __LINE__);
                Http::Err(500, "Could not load model $name. Report to Technical Support.", __METHOD__ . ':' . __LINE__);
                die;
            }

            $class = new $name($class_payload);
            unset($file, $rute, $arg, $name, $data, $class_payload);
            return $class;
        }
    }

    public static function Lib($rute = 'none', $data = [])
    {
        $file = ROOTDIR . 'libs/' . $rute . '.lib.php';

        if (!file_exists($file)) {
            Alerts::Server("Error: Could not load lib $file. " . __METHOD__ . ':' . __LINE__);
            Http::Err(500, "File lib, not found or could not be loaded. Report to Technical Support.", __METHOD__ . ':' . __LINE__);
            die;
        }

        $arg = explode('/', $rute);
        $name = isset($arg[1]) ? $arg[1] . 'Lib' : $rute . 'Lib';

        if (!class_exists($name)) {
            extract($data);
            require_once $file;

            if (!class_exists($name)) {
                //Si no existe la clase, se envia error 500 y se informa a soporte del error.
                Alerts::Server("Error: Could not load lib $name. " . __METHOD__ . ':' . __LINE__);
                Http::Err(500, "Could not load lib $name. Report to Technical Support.", __METHOD__ . ':' . __LINE__);
                die;
            }

            if (isset($class_payload)) {
                $class = new $name($class_payload);
            } else {
                $class = new $name;
            }

            return $class;
        }
    }

    public static function File($rute = 'none', $data = [])
    {
        $file = ROOTDIR . $rute . '.php';

        if (!file_exists($file)) {
            Alerts::Server("Error: Could not load file $file. " . __METHOD__ . ':' . __LINE__);
            Http::Err(404, "File require '$rute', not found.", __METHOD__ . ':' . __LINE__);
            die;
        }

        extract($data);
        require_once $file;
    }
    public static function View(string $viewRute, array $data = [])
    {
        $file = ROOTDIR . 'views/' . $viewRute . '.view.php';

        if (!file_exists($file)) {
            Alerts::Server("Error: Could not load file $file. " . __METHOD__ . ':' . __LINE__);
            Http::Err(404, "File require '$viewRute', not found.", __METHOD__ . ':' . __LINE__);
            die;
        }

        extract($data);
        require_once $file;
    }

    public static function modules($mName, $data = array())
    {
        $module = ROOTDIR . 'views/modules/' . $mName . '.php';

        if (file_exists($module)) {
            extract($data);
            include_once($module);
        } else {
            include_once(ROOTDIR . 'views/modules/default.module.php');
        }
    }

    public static function User($string = '')
    {
        if (!is_string($string)) {
            return 'NULL';
            die;
        }

        switch ($string) {
            case 'UserData':
                //$return = $user->_getUserData(App::$UserKey);
                break;
            default:
                $return = 'NULL';
                break;
        }

        Response::Json($return);
        return $return;
    }
}
