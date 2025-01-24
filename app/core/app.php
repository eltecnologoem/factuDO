<?php

class App
{

    public static $lang;
    public static $site;
    private $cc;


    public function __construct()
    {
        self::$lang = $this->getLang();

        Alerts::Server('Load App: '.__METHOD__.':'.__LINE__);
        //User::ValidateToken();
        /* if (Session::Exists('authUser')) {
            if (Session::get('authUser')) {
                User::ValidateToken();
                User::set(Session::get('authUser'));
            }
        } */

        $url = Http::filterUrl();

        if (empty($url)) {
            $controller = $this->LoadController('dashboard');
            //$controller->i();
        } else {
            $controller = $this->LoadController($url[0]);
            unset($url[0]);
        }

        $method = 'index';
        if (isset($url[1])) {
            $method = $url[1];
        }

        $method = $this->LoadMethod($controller, $method);
        unset($url[1]);
        //unset($url[1]); // Eliezer *Debo revisar como eliminar la variable $url[1] sin afectar categoria

        $params = $url ? array_values($url) : array();
        unset($url);
        $controller->{$method}($params);
        Activity::Blog();
        Alerts::Server('End load Class App->__construct()');
        die;
    }

    private function LoadController($controller)
    {
        $controller = str_replace('-', '', $controller);
        $controller = str_replace('_', '', $controller);
        if (file_exists(ROOTDIR . 'controllers/' . $controller . 'Controller.php')) {
            require ROOTDIR . 'controllers/' . $controller . 'Controller.php';
            $this->cc = $controller.'Controller'; //Current Controller
            $controllers = new $this->cc;
            Alerts::Server('Execute App->LoadController(' . $this->cc . ')');
            return $controllers;
            exit();
        } else {
            Http::Err(404);
        }
        exit();
    }

    private function LoadMethod($controller, $method)
    {
        $method = str_replace('-', '', $method);
        $method = str_replace('_', '', $method);
        if (method_exists($controller, $method)) {
            Alerts::Server('Execute App->LoadMethod(' . $method . ')');
            return $method;
        }

        Http::Err('404');
    }

    public static function Visit()
    {
        return Http::Visit();
    }

    // Obtener URI actual
    public function link()
    {
        return Http::link();
    }

    protected function getLang()
    {
        $lang = 'es';
        if (isset($_GET['lang'])) {
            $lang = $_GET['lang'];
            setcookie('lang', $lang);
        }
        if (isset($_COOKIE["lang"]) and !isset($_GET['lang'])) {
            $lang = $_COOKIE["lang"];
        }

        if (file_exists(ROOTDIR . 'config/lang_' . $lang . '.json')) {
            $json = file_get_contents(ROOTDIR . 'config/lang_' . $lang . '.json');
            $json = json_decode($json);
            return $json;
        }

        $json = file_get_contents(ROOTDIR . 'config/lang_es.json');
        $json = json_decode($json);
        return $json;
    }

    public static function Debug($var, $die = true)
    {
        if (_dev_ or $die == 'force') {
            echo '<pre>';
            print_r($var);
            echo '</pre>';

            if ($die) {
                die;
            }
        }
    }
}
