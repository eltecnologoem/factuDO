<?php

class Model
{
  private static $config;
  private static $api;
  private static $client_id = false;
  private static $client_secret = false;
  public static $userToken = false;
  public static $userRefreshToken = false;

  private static $jsonApi = ROOTDIR . 'config/api_factus';

  public function __construct()
  {
    self::ApiConf();
  }

  // Funcion que se encarga de extraer los datos de configuracion para conexion a la API
  // Asigna los valores a las vairiables correspondientes.
  private static function ApiConf()
  {
    if (!json::Exists(self::$jsonApi)) {
      Alerts::Server('Error conf API - JSON "' . self::$jsonApi . '" not exists. | ' . __METHOD__ . ':' . __LINE__);
      return false;
    }

    $api = json::Get(self::$jsonApi); // Si los datos cambian, favor editar el archivo .json asociado.

    self::$api = (_dev_) ? $api->dev_url : $api->prod_url;

    self::$client_id = $api->client_id;
    self::$client_secret = $api->client_secret;
    if ($authUser = Session::get('authUser')) {
      self::$userToken = $authUser['access_token'] ?? null;
      self::$userRefreshToken = $authUser['refresh_token'] ?? null;
    }

    return true;
  }

  // Funcion que realiza llamada a la API-Rest.
  // Recibe los datos mediante un array.
  // Los parametros de autenticacion se leen desde un json alojado en app/config
  protected static function ApiCall($data)
  {
    if (!self::ValidMethod($data['method'])) {
      unset($data);
      Alerts::Server('Error Model->ApiCall(method undefined).');
      return false;
    }

    if (!isset(self::$api)) {
      self::ApiConf(); // Se ejecuta cuando el constructor no se activa. Pendiente de validad la causa. Anomalia vista desde lib/Lib_Bank
    }

    $method = $data['method']; // Define el metodo de la solicitud (POST, GET, PUT, DELETE)
    $uri = $data['uri']; // La uri contiene la ruta hacia donde ira la peticion, haciendo uso de $_GET en algunos casos.
    unset($data['method'], $data['uri']); // Eliminamos las variables innecesarias antes de enviar $data a la API.

    if (!$payload = Request::getKey($data, 'payload')) {
      Alerts::Server(__METHOD__ . '(' . $method . ' - ' . self::$api . $uri . ') | Without payload.');
      $payload = [];
    }

    if (Request::getKey($data, 'addClientKey')) {
      $payload['client_id'] = self::$client_id;
      $payload['client_secret'] = self::$client_secret;
    }

    if (Request::getKey($data, 'sendJson')) {
      $payload = json_encode($payload);
    }

    $apiPayload = [
      CURLOPT_URL => self::$api . $uri, // Obtiene la url completa de la API para la solicitud.
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => $method,
      CURLOPT_POSTFIELDS => $payload,
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json', //Tipo de contenido por defecto "json".
        self::$userToken ? 'Authorization: Bearer ' . self::$userToken : ''
      ),
    ];

    $curl = curl_init();
    curl_setopt_array($curl, $apiPayload);

    $response = curl_exec($curl);
    curl_close($curl);

    $response = json_decode($response);
    $status = Request::getKey($response, 'status');
    $message = Request::getKey($response, 'message');

    if ($status == 'Conflict') {
      Alerts::Server('Error: ' . $message . ' | ' . __METHOD__ . ':' . __LINE__);
      Alerts::set('Error: ' . $message, 'danger');
      return false;
    }

    if (Request::getKey($response, 'access_token') || Request::getKey($response, 'refresh_token')) {
      return $response;
    }

    if (!$results = Request::getKey($response, 'data')) {
      Alerts::Server('Error Model->ApiCall(data undefined). | ' . $message . ' - ' . $uri);
      return false;
    }

    Alerts::Server('Execution Model->ApiCall(' . $method . ' - ' . self::$api . $uri . ') finished.');
    return $results;
  }

  protected static function apiLogin(array $data)
  {

    if (!isset(self::$api)) {
      self::ApiConf(); // Se ejecuta cuando el constructor no se activa. Pendiente de validad la causa. Anomalia vista desde lib/Lib_Bank
    }

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => self::$api . '/oauth/token',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array(
        'grant_type' => 'password',
        'client_id' => self::$client_id,
        'client_secret' => self::$client_secret,
        'username' => $data['email'],
        'password' => $data['password']
      ),
      CURLOPT_HTTPHEADER => array(
        'Accept: application/json',
        'Authorization: ••••••'
      ),
    ));

    $response = curl_exec($curl);
    $response = json_decode($response);
    curl_close($curl);
    return $response;
  }

  private static function ValidMethod($method)
  {
    $valid = array('POST', 'GET', 'PUT', 'DELETE');

    if (in_array($method, $valid)) {
      return true;
    }

    Alerts::Server('Error invalid API method "' . $method . '". - Model->ValidMethod(' . $method . ').');
    return false;
  }

  //Comunicacion con API Static Image
  public static function ApiStatic($data)
  {
    if (is_null(User::get('token'))) {
      unset($data);
      Alerts::Server('Error Model->ApiStatic() not user token found.');
      return false;
      exit();
    }

    if (!self::ValidMethod($data['method'])) {
      unset($data);
      Alerts::Server('Error Model->ApiCall(method undefined).');
      return false;
      exit();
    }

    $host = __static_img__;
    $curl = curl_init();
    $type = $data['method']; // Define el metodo de la solicitud (POST, GET, PUT, DELETE)
    $uri = $data['uri']; // La uri contiene la ruta hacia donde ira la peticion, haciendo uso de $_GET en algunos casos.
    unset($data['method'], $data['uri']); // Eliminamos las variables innecesarias antes de enviar $data a la API.

    curl_setopt_array($curl, array(
      CURLOPT_URL => $host . $uri . '/', // Obtiene la url completa de la API para la solicitud.
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => 'json',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => $type,
      CURLOPT_POSTFIELDS => json_encode($data),
      CURLOPT_HTTPHEADER => array(
        'Apikey: f3658bea4f7449233eef104d66337ca1',
        'User-Token: ' . User::get('token'),
        'Content-Type: application/json'
      ),
    ));

    $rs = curl_exec($curl);
    curl_close($curl);

    //Alerts::Server('Execution Model->ApiCall('.$type . ' - ' . $host.$uri.') finished.');
    //App::Debug($rs);
    return $rs;
  }
}
