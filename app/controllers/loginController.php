<?php

Get::Model('Auth');
class LoginController extends Controller
{
    public function index()
    {
        if(Session::Exists('authUser')){
            Http::redirect('/');
        }

        Http::redirect('/auth');
    }
}
