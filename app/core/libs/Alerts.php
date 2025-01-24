<?php

class Alerts {
    // Tomar en cuenta, que el Loader.php ubicado en la raiz de App/, realiza la carga de session_start. \\

    private static function init(){
        if(Session::Open());
    }

    public static function set($msg, $color){

        //if(!isset($_SESSION['msg'])){
        if(!Session::Exists('msg')){
            Session::set('msg', array());
            //$_SESSION['msg'] = array();
        }

        $data['MSG'] = $msg;
        $data['Alert'] = $color;
        array_push($_SESSION['msg'], $data);

    }

    public static function get(){

        if(isset($_SESSION['msg'])){
            return $_SESSION['msg'] ;
        } else {
            return false;
        }

    }

    public static function check(){

        if(isset($_SESSION['msg'])) {//AND count($_SESSION['msg'] > 0)){
            return  true;
        } else {
            return false;
        }

    }

    public static function delete(){

        unset($_SESSION['msg']);

    }

    public static function Server($msg){ // Se creara un archivo de registro por día, con los errores del sistema.
        if(!_logs){ // Evalua si la opcion logs esta activa, de lo contrario no se ejecuta la funcion.
            return false;
            exit();
        }

        error_reporting(E_ALL);
        ini_set('ignore_repeated_errors', TRUE);
        ini_set('display_errors', FALSE);
        ini_set('log_errors', TRUE);
        $day = date('d-m-Y',time());
        ini_set("error_log", ROOTDIR."Logs/Server/PHP_Server_Errors_$day.log");
        error_log($msg);
    }

    public static function Payments($msg){ // Se creara un archivo de registro por día, con los errores del sistema.
        error_reporting(E_ALL);
        ini_set('ignore_repeated_errors', TRUE);
        ini_set('display_errors', FALSE);
        ini_set('log_errors', TRUE);
        $day = date('d-m-Y',time());
        ini_set("error_log", ROOTDIR."Logs/Payments/Payments_Errors_$day.log");
        error_log($msg);
    }

}