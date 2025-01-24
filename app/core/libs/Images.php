<?php

class Images {

    public static function _time(){
        return time();
    }
    // Valida si existen las sesiones de usuario (member y auth_user) y si los token coinciden.
    // Si no existen o no coinciden los datos, retorna false.
    private static function Exists(){
        if(!Session::Exists('member') OR !Session::Exists('auth_user')){
            return false;
        }

        if(Session::get('member') != Session::get('auth_user')->token_auth){
            return false;
        }

        return true;
    }

    // Retorna datos de usuario logueado si pasa validacion de self::Exists.
    // Los parametros aceptados equivalen a las variables privadas definidas al inicio de esta clase.
    // Retorna NULL si no se cumplen las condiciones.
    public static function get($param){
        return self::${$param};

        return NULL;
    }

    // Retorna la imagen de perfil usuario logueado codificada en base64.
    // Si el objeto no existe, retorna imagen por defecto.
    public static function bg($img, $base64 = true){

        //$ImgDir = __static_img__.'banners-pages/'.$img;
        //$ImgDir = 'https://static.gamerclub.vip/api/?loc=webBG&image='.$img;
        if($img == 'default'){
            $img = 'default.jpg';
        }
        $img =  __static_img__.'webBG/'.$img;

        $headers = @get_headers($img);
        if($headers[0] != 'HTTP/1.1 200 OK'){
            $UrlImg = '';
        }

        if($base64){ //Por defecto se retorna en bas64 a menos que se especifique false en la solicitud.
            $img = file_get_contents($img);
            $img = base64_encode($img);
        } 

        return $img;

    }

    public static function Article($img){
        $UrlImg =  __images__.$img;

        $headers = @get_headers($img);
        return $UrlImg;
        die;

        if($headers[0] != 'HTTP/1.1 200 OK'){
            $UrlImg = '';
        }

        /* if($base64){ //Por defecto se retorna en bas64 a menos que se especifique false en la solicitud.
            $ImgBin = file_get_contents($UrlImg);
            $Img = base64_encode($ImgBin);
        } else {
        } */
        return $UrlImg;
        
    }
    //Imagenes de Usuarios, debe ser controlada por la calse user

    // Retorna la imagen de fondo perfil usuario logueado codificada en base64.
    // Si el objeto no existe, retorna imagen por defecto.
    public static function getImageBG(){
        if(!self::Exists()){
            return NULL;
        }
        //$img = __static_img__ . 'UserProfile/'.$id.'.jpg';
        $img = __static_img__ . 'UserProfile/BG/'.self::get('id').'.jpg';
        $headers = @get_headers($img);

        if($headers[0] != 'HTTP/1.1 200 OK'){
            $img = ROOTDIR . 'views/images/UserProfile/default.jpg';
        }

        $ImgBin = file_get_contents($img);
        $Img = base64_encode($ImgBin);
        return $Img;
        
    }

    // Retorna la imagen rango usuario logueado codificada en base64.
    // Si el objeto no existe, retorna imagen por defecto.
    public static function getImgRank(){//$rank = 'default'){
        if(!self::Exists()){
            return NULL;
        }
        $rank = self::Rank();
        
        $ImgDir = ROOTDIR . 'views/images/Rank/rank_'.$rank.'.png';

        if(!file_exists($ImgDir)){
            $ImgDir = ROOTDIR . 'views/images/Rank/default.png';
        }
        
        $ImgBin = file_get_contents($ImgDir);
        $Img = base64_encode($ImgBin);
        return $Img;
    }

    public static function Rank(){

    }
}
