<?php

    class AuthModel extends Model {
        public static function getTokenV1(array $data){
            $response = self::apiLogin($data);
            
            if(!$auth = Request::getKeys($response, ['access_token','refresh_token'])){
                Alerts::set('Authentication failed', 'warning');
                return false;
            }

            Session::set('authUser', [
                'access_token' => $auth['access_token'],
                'refresh_token'=>$auth['refresh_token'],
                'expires_in'=>time()+30
            ]);

            return true;
        }

        public static function getToken(array $data){
            if(!Request::getKeys($data, ['email','password'])){
                Alerts::set('Authentication data is required (email, password)', 'danger');
                return false;
            }
            $payload = [
                'method' => 'POST',
                'uri' => '/oauth/token',
                'addClientKey' => true,
                'sendJson' => true,
                'payload' => [
                    'grant_type' => 'password',
                    'username' => $data['email'],
                    'password' => $data['password']
                ]
            ];
            $response = self::ApiCall($payload);
            
            if(!$auth = Request::getKeys($response, ['access_token','refresh_token'])){
                Alerts::set('Authentication failed', 'warning');
                return false;
            }

            Session::set('authUser', [
                'access_token' => $auth['access_token'],
                'refresh_token'=>$auth['refresh_token'],
                'expires_in'=>time()+3600
            ]);

            return true;
        }

        public static function refreshToken(){
            if(!Session::Exists('authUser')){
                Alerts::set('No session active', 'warning');
                return false;
            }

            $payload = [
                'method' => 'POST',
                'uri' => '/oauth/token',
                'addClientKey' => true,
                'sendJson' => true,
                'payload' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => Session::get('authUser')['refresh_token']
                ]
            ];

            $response = self::ApiCall($payload);
            
            if(!$auth = Request::getKeys($response, ['access_token','refresh_token'])){
                Alerts::set('Reauthentication failed', 'warning');
                
                Session::destroy('authUser');
                return false;
            }
            Alerts::set('Reauthentication success', 'success');
            
            Session::set('authUser', [
                'access_token' => $auth['access_token'],
                'refresh_token'=>$auth['refresh_token'],
                'expires_in'=>time()+3600
            ]);
            
            return true;
        }
    }