<?php

    class HttpError extends Controller {

        public function i($err = '404'){
                $this->GetModules('head/head', ['title' => $err]); 
                $this->view('ErrorPage/'.$err);
                $this->GetModules('footer/footer'); 
        }

        public function test(){
            echo 'Hi from Notfound pages.';
            exit();
        }

    }