<?php
//session_start();
if (session_status() == PHP_SESSION_NONE) {
    session_name('authUser');
    session_start();
}

date_default_timezone_set('America/Santo_Domingo');

define("ROOTDIR", dirname(__FILE__) . "/");

if (ROOTDIR . 'loader.php' != dirname(__FILE__) . '/loader.php') {
    require('views/ErrorPage/error_dir.php');
    return http_response_code(500);
    exit();
}

require ROOTDIR . 'config/site.conf.php'; // Define las constantes de uso comun de la App.
require ROOTDIR . 'core/ini.php';
$app = new App;
