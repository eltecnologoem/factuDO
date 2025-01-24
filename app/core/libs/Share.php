<?php

class Share {

    // Obtener URI actual
    private static function link(){
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $url = "https://"; 
          }else{
            $url = "http://"; 
          }    
          $link =  $url . $_SERVER['HTTP_HOST'] .  $_SERVER['REQUEST_URI'];    
      return $link;
    }
    
    // Prepara los datos para compartir en twitter
    public static function twitter($text){
        $text = str_replace(' ', '+', $text);
        return $text . '+' . self::link().self::setFGP();
    }

    // Prepara los datos para compartir en twitter
    public static function facebook(){
        return self::link().self::setFGP();
    }

    public static function fb_meta($title, $resume, $image){
        $meta = '
            <meta property="og:image"        content="'.__images__.$image.'" />
            <meta property="fb:app_id"       content="1186796945129945" />
            <meta property="og:type"         content="article" />
            <meta property="og:title"        content="'.$title.'" />
            <meta property="og:description"  content="'.$resume.'" />
            <meta property="og:url"          content="'.self::link().self::setFGP().'" />
            <br>';

         return $meta;
    }
    
    private static function setFGP(){
        if(is_numeric(User::get('id'))){
            $ref = '/?fgp='.User::get('fgp');
        } else {
            $ref = '';
        }

        return $ref;
    }
}

?>