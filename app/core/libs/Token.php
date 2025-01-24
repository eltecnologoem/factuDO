<?php

    class Token {

        private static $numeric = '0123456789';
        private static $string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        private static $alfanumeric = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        private static $especial = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@*-/!.';
        
        public static function generate($length = 64) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@*-/!.';
            $charactersLength = strlen($characters);
            $key = '';
            for ($i = 0; $i < $length; $i++) {
                $key .= $characters[rand(0, $charactersLength - 1)];
            }

            return $key;
        }

        public static function get($length = 14, $format = 'alfanumeric') {
            if(!isset(self::${$format})){
                return NULL;
            }
            $characters = self::${$format};
            $charactersLength = strlen($characters);
            $key = '';
            for ($i = 0; $i < $length; $i++) {
                $key .= $characters[rand(0, $charactersLength - 1)];
            }
            return $key;
        }



    }

?>