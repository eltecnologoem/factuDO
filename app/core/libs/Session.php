<?php

class Session
{

    public static $user = [];
    public static $response;

    public static function Open()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['member'])) {
            return $_SESSION['member'];
        } else {
            return false;
        }
    }

    // Funcion para eliminar cookie de auth
    public static function Close()
    {
        /* if(self::Exists('member') AND self::Exists('auth_user')){
            require(ROOTDIR.'lib/Lib_ControlLogin.php');
            $rq = new Lib_ControlLogin;
            $rq->SetOffline(User::get('id'));
            //Controller::UserActivity('Failed to log out.');
            self::destroy('member');
            self::destroy('auth_user');
            return true;
        } */

        return false;
    }

    public static function Exists($key)
    {
        if (isset($_SESSION[$key])) {
            return true;
        } else {
            return false;
        }
    }

    public static function set($key, $value)
    { // Crear una variable para $_SESSION asigando $key como identificador y $value como datos de la misma.
        #self::init();
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {

        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return false;
        }
    }

    public static function destroy($key)
    {

        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
            #session_destroy($_SESSION[$key]);
        }

        $rs = self::get($key);

        if (!$rs) {
            return true;
        }

        return false;
    }

    private function init()
    { // Iniciador Variable $_SESSION.        
        if (!isset($_SESSION)) {
            //Controller::OpenSession();
        }
    }
}

class Cookie
{

    public static function Set($key, $value)
    {
        setcookie($key, $value, [
            'expires' => time() + 3600,
            'path' => '/',
            'domain' => 'gamerclub.local',
            'secure' => false,
            'httponly' => true
        ]);

        if (!isset($_COOKIE[$key])) {
            return false;
        }
        return true;
    }

    public static function Get($key)
    {
        if (isset($_COOKIE[$key])) {
            return $_COOKIE[$key];
        } else {
            return false;
        }
    }
}
