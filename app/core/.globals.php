<?php

    class Globals {

        public function Alerts(){
            $alerts = new Alerts;
            return $alerts;
        }

        public function Response(){
            $response = new Response;
            return $response;
        }

        public function Json($data, $base64 = NULL){
            Response::Json($data, $base64);
            die;
        }
        public function Err($err, $message = '', $org = ''){
            Http::Err($err, $message, $org);
            die;
        }

        public function view(string $viewRute, array $data = []){
            Get::View($viewRute, $data);
        }

        public function Model($rute, $data = []){
            return Get::Model($rute, $data);
        }

        public function Lib($rute, $data = []){
            return Get::Lib($rute, $data);
        }

        public function Controller($rute, $data = []){
            //return Get::Controller($rute, $data);
        }
    }
