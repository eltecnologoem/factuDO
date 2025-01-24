<?php
Get::Model('auth');

class AuthController extends Controller
{
    public function index()
    {
        $data['back'] = '';

        if (isset($_SERVER['HTTP_REFERER'])) {
            $data['back'] = $_SERVER['HTTP_REFERER'];
        }

        if (Session::Exists('authUser')) {
            Http::redirect('/dashboard');
            exit;
        }

        if (isset($_POST['userLogin'])) {
            if (AuthModel::getToken($_POST)) {
                Http::redirect('/dashboard');
            }
        }

        $this->view('auth/login', $data);
        exit;
    }

    public function refresh()
    {
        if (AuthModel::refreshToken()) {
            Http::redirect('/auth');
        }

        if ($_SERVER['HTTP_REFERER']) {
            Http::redirect($_SERVER['HTTP_REFERER']);
        }

        Http::redirect('/dashboard');
    }

    public function signup()
    {
        $this->view('auth/signup');
        die;
    }

    public function close()
    {
        if (!Session::Exists('authUser')) {
            Alerts::set(App::$lang->alert->not_data_login, 'warning'); //No tienes sesión activa
            Http::back();
            exit();
        }

        $response = Session::Close();

        if ($response) {
            Alerts::set(App::$lang->alert->session_close, 'success'); //Sesión cerrada
            Http::back();
            exit();
        } else {
            Alerts::set(App::$lang->alert->session_close_error, 'warning'); //No pudimos cerrar tu session
            Http::redirect('/dashboard/support');;
            exit();
        }
    }
}
