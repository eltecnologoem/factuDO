<?php
    define('_dev_',         true); //Si es true, conecta con API y dominios locales.
    define('_maintenance',  false); // Si es true, se activa modo mantenimiento e impide el acceso a la web.
    define('static_local', false);

    $static = 'https://static.factu.do/'; // URL de la carpeta static
    $static_img ='https://static.factu.do/images/'; // URL de la carpeta static/images
    $_images = 'https://images.factu.do/'; // URL de la carpeta images
    $url = 'https://factu.do/'; // URL de la aplicacion

    if(_dev_){
        $url = 'http://factu.local/'; // URL de la aplicacion en modo local
    }

    define('_name', 'FactuDO'); // Aqui define el nombre de la Aplicacion.
    define('_url', $url); // URL de la aplicacion
    define('_Logo', '<img src="/images/_Logo.jpg" width="60" alt="">'); // Logo de la aplicacion

    define('__static__', $static); // URL de la carpeta static
    define('__static_img__', $static_img); // URL de la carpeta static/images
    define('__images__', $_images); // URL de la carpeta images

    // Log On/Off
    define('_logs', true); // Si es true, activa los registros de evento. Por defecto "true".