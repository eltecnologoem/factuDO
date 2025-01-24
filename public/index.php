<?php
// Archivo encargado de recibir las peticiones y enrutarlas segun configuraciones internas definidas en App.
    $loader = '../app/loader.php';
    if(!file_exists($loader)){
        require('../app/views/errors/error_dir.php');
        die;
    }
    require $loader;