<?php

class User extends Model
{
    private static $token = '';
    private static $refresh_token = '';

    public static function _time()
    {
        return time();
    }
    // Valida si existen las sesiones de usuario (member y auth_user) y si los token coinciden.
    // Si no existen o no coinciden los datos, retorna false.
    private static function Exists()
    {
        if (Session::Exists('authUser')) {
            return true;
        }

        return false;
    }

    // Retorna datos de usuario logueado si pasa validacion de self::Exists.
    // Los parametros aceptados equivalen a las variables privadas definidas al inicio de esta clase.
    // Retorna NULL si no se cumplen las condiciones.
    public static function get($param)
    {
        if (!self::set()) {
            return 'NULL';
        }
        if (isset(self::${$param}) and !is_null(self::${$param})) {
            return self::${$param};
        }

        return 'NULL';
    }

    // Recibe datos de usuario logueado si pasa validacion de self::Exists.
    // Los valores son asigandos desde el login y/o desde core/App a inicio.
    // Si no pasa validacion, no se almacenan los datos.
    public static function set()
    {
        if (!self::Exists()) {
            return false;
        }

        if($user = Session::get('authUser')){
            Model::$userToken = $user['access_token'];
            Model::$userRefreshToken = $user['refresh_token'];
            return true;
        }

        return false;
    }

    public static function isAuth(){
        if(!Session::Exists('authUser')){
            Http::redirect('/auth#not-login');
        }

        $auth = Session::get('authUser');

        if (Request::getKeys($auth, ['access_token','refresh_token','expires_in'])) {
            if(time() > $auth['expires_in']){
                Alerts::set('Su sessión ha expirado.', 'warning');
                Http::redirect('/auth/refresh');
            }

            return true;
        }

        Http::redirect('/auth');
    }

    public static function ValidateToken()
    {
        if ($user = Session::get('authUser')) {
            $token = $user['access_token'];
            if(time() > $user['expires_in']){
                Alerts::set('Su sessión ha expirado.', 'warning');
                Http::redirect('/auth/refresh');
            }

            /* $payload = [
                'uri'       => 'auth/permissions',
                'method'    => 'GET'
            ];

            $response = Model::ApiCall($payload);

            if (!Request::getKey($response, 'results')) {
                $payload = array(
                    'uri' => 'auth/logout',
                    'method' => 'PUT'
                );

                $response = Model::ApiCall($payload);

                if (!Request::getKey($response, 'error')) {
                    Alerts::set('Su sessión ha expirado.', 'warning');
                    Session::destroy('authUser');
                }
            } */
        }
    }
}
