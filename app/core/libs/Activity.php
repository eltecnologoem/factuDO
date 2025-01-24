<?php
class Activity extends Model
{

  public static function create()
  {
  }

  public static function add()
  {
  }

  public static function get(string $sources = 'logs')
  {
    //User::perm('R_Logs');
    if ($sources == 'logs') {
      $uri = '';
    } elseif ($sources == 'bank') {
      $uri = 'bank/account/transaction-history';
    } else {
      return [];
    }

    $payload = [
      'uri'       => $uri,
      'method'    => 'GET'
    ];

    if ($page = Request::getKey($_GET, 'page') and is_numeric($page)) {
      $page = filter_var($page, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $payload['uri'] .= "?page=$page";
    }

    $response = self::ApiCall($payload);
    $error = Request::getKey($response, 'error');
    $results = Request::getKey($response, 'results') ?: NULL;

    if ($error or !$results) {
      $reason = Request::getKey($results, 'reason');
      Alerts::set("No se pudo completar la solicitud: $reason", 'warning');
      return [];
    }

    return $results;
  }

  ### Registro de actividad
  public static function User($activity)
  {
    if (!Session::Exists('member')) {
      return false;
      die;
    }

    //{"action":"create","userID":"12","sessionID":"5454sdsd4s5fsdfs","ipAddress":"192.168.5.7","uri":"/blog","date":"1634149881"}
    $data =
      [
        'token'     => User::get('token'),
        'uri'       => 'activity',
        'method'    => 'POST',
        'action'    => 'create',
        'type'      => 'User',
        'userID'    => User::get('id'),
        'sessionID' => session_id(),
        'ipAddress' => cIP::get(),
        'activity'  => $activity,
        'date'      => time()
      ];

    //$rs = json_decode(self::ApiCall($data));
    unset($data, $activity, $rs);
  }

  public static function UserOld($activity)
  {
    if (!Session::Exists('member')) {
      return false;
    }

    $id_user = User::get('id');
    $ip_address = cIP::get();
    $date_access = time();
    $session_id = session_id();

    $data[$id_user] = array(
      'user_id'     => $id_user,
      'session_id'  => $session_id,
      'ip_address'  => $ip_address,
      'activity'    => $activity,
      'date_access' => $date_access
    );

    /* $ruta = ROOTDIR.'Data/activity/users_log';

          if(json::Exists($ruta)){
              $rs = json::DataAdd($data, $ruta);
              return $rs;
          } else {
              if(json::Create($data, $ruta)){
                return  true;
              } else {
                return false;
              }
          } */

    return false;
  }

  public static function Blog()
  {
    if (!Session::Exists('member')) {
      return false;
    }

    $activity = 'ActivityWeb-> |IP Address: ' . cIP::get() . '|Session ID: ' . session_id() . '| Browser Data: ' . $_SERVER['HTTP_USER_AGENT'] . '|';

    $data =
      [
        'uri'       => 'activity',
        'method'    => 'PUT',
        'action'    => 'create',
        'type'      => 'Blog',
        'userID'    => User::get('id'),
        'sessionID' => session_id(),
        'ipAddress' => cIP::get(),
        '_uri'      => Http::uri(),
        'activity'  => $activity,
        'date'      => time()
      ];

    //$rs = json_decode(self::ApiCall($data));
    //App::Debug($rs);
    unset($data, $activity, $rs);
  }
  public static function BlogOLD()
  {
    #quede en crear funcion para registrar actividad de administradores dentro de Blog 
    if (!Session::Exists('member')) {
      return false;
    }

    $ip_address = cIP::get();
    $date_access = time();
    $session_id = session_id();
    $uri = Http::uri();

    $data[time()] = array(
      'user_id'     => User::get('id'),
      'session_id'  => session_id(),
      'ip_address'  => cIP::get(),
      'uri'         => Http::uri(),
      'date_access' => $date_access
    );

    $date = date('d-m-y-h', time());
    $ruta = ROOTDIR . 'Data/activity/BlogActivity';

    if (json::Exists($ruta)) {
      $rs = json::DataAdd($data, $ruta);
      return $rs;
    } else {
      if (json::Create($data, $ruta)) {
        return  true;
      } else {
        return false;
      }
    }
  }

  public static function getByURI($uri = '')
  {
    $dir = ROOTDIR . 'Data/activity/BlogActivity';
    $logs = json::get($dir);

    $rs = [];
    if ($logs > 1) {
      foreach ($logs as $log) {
        if (empty($uri)) {
          $rs[] = $log;
        } else {
          foreach ($log as $log) {
            if ($log->uri == $uri) {
              $rs[] = $log;
            }
          }
        }
      }
    }

    return $rs;
  }
}
