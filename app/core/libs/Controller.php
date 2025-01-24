<?php

class Controller
{

  public function view($viewFileName, $data = [])
  {
    Activity::User(Http::Visit());
    if (file_exists(ROOTDIR . 'views/' . $viewFileName . '.view.php')) {
      extract($data);
      require_once(ROOTDIR . 'views/' . $viewFileName . '.view.php');
    } else {
      require_once(ROOTDIR . 'views/ErrorPage/404.php');
    }
  }

  // Solicitar modulos
  public static function GetModules($mName, $cap = array())
  {
    if (file_exists(ROOTDIR . 'views/modules/' . $mName . '.php')) {
      extract($cap);
      require_once(ROOTDIR . 'views/modules/' . $mName . '.php');
    } else {
      require_once(ROOTDIR . 'views/modules/default.module.php');
    }
  }

  public static function GetVendor($vendor, $data = array())
  {
    extract($data);
    if (!file_exists(ROOTDIR . 'vendor/' . $vendor . '.php')) {
      require_once(ROOTDIR . 'vendor/none.php');
    }
    require_once(ROOTDIR . 'vendor/' . $vendor . '.php');
  }
}
