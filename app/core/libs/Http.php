<?php

class Http
{

    public static function filterUrl()
    {
        if (isset($_GET['cmd'])) {

            $nonSlash = rtrim($_GET['cmd'], '/');
            $var = strtolower($nonSlash);

            $filteredUrl = filter_var($var, FILTER_SANITIZE_URL);
            $finalUrl = explode('/', $filteredUrl);
            #exit(end($finalUrl));
            return $finalUrl;
        }
    }

    public static function url()
    {
        return self::filterUrl();
    }

    public static function redirect($uri)
    {
        if ($uri == '/') {
            header('Location: /');
            die;
        } else {
            header('Location: ' . $uri);
            die;
        }
        die;
    }

    public static function back()
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            exit(header('Location: ' . $_SERVER['HTTP_REFERER']));
        }
    }

    // Obtener URI actual
    public static function uri()
    {
        $uri = filter_var($_SERVER["REQUEST_URI"], FILTER_SANITIZE_URL);
        return $uri;
    }

    // Obtiene la url de referencia para validad si aplica bonificacion
    public static function ValidReferer()
    {
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : NULL;
        if (is_null($referer)) {
            return false;
            exit();
        }

        $http = explode('//', $referer)[1];
        $http = explode('/', $http)[0];

        $valid = array(
            'facebook.com',
            'www.facebook.com',
            'twitter.com',
            'www.twitter.com',
            'youtube.com',
            'www.youtube.com',
            'gamerclub.local',
        );

        if (in_array($http, $valid)) {
            Alerts::Server('Valid Referer. App->ValidReferer(' . $referer . ')');
            return $http;
            exit();
        }

        return false;
        exit();
    }

    // Retorna la uri con string Visit->, para registrar en dash de usuario.
    public static function Visit()
    {
        $uri = self::uri();

        if ($uri == '/') {
            $uri = '/home';
        }

        return 'Visit->' . $uri;
    }

    // Obtener URI actual
    public static function link()
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $url = "https://";
        } else {
            $url = "http://";
        }

        $link =  $url . $_SERVER['HTTP_HOST'] .  $_SERVER['REQUEST_URI'];

        return $link;
    }

    public static function in_uri($arg)
    {
        $uri = explode('/', filter_var($_SERVER["REQUEST_URI"], FILTER_SANITIZE_URL));
        if (in_array($arg, $uri)) {
            return true;
        }
        return false;
    }

    public static function Err($code = '404')
    {
        require_once(ROOTDIR . 'controllers/HttpErr/HttpError.php');
        $err = new HttpError;
        $err->i($code);
        die;
    }
}
