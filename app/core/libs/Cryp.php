<?php

    class Cryp {
        private static $key = '#Pa25c6c7ff35b9979b151f2136cd13b0ff65';
        private static $method = 'AES-256-CBC';
        private static $iv = '4957315784587423';
        private static $tag = 'AEAD';

        public static function encode($data){
            $rs = openssl_encrypt($data, self::$method, self::$key, $options=0, self::$iv, self::$tag);
            return $rs;
        }

        public static function decode($data){
            $rs = openssl_decrypt($data, self::$method, self::$key, $options=0, self::$iv);
            return $rs;
        }
    }

?>