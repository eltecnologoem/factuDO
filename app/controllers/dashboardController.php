<?php
User::isAuth();
class DashboardController extends Controller
{
    public function index()
    {
        //echo Session::get('authUser')['access_token'];
        $this->GetModules('head/head', ['title' => 'Home', 'breadcrumb' => '']);
        $this->view('dash/home');
        $this->GetModules('footer/footer');
    }
}
