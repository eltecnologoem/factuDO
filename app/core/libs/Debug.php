<?php

    class Debug {

        public static function run($var){
            if(_dev_){
                echo '<pre>';
                print_r($var);
                echo '</pre>';
                die;
            }
        }
    }

?>