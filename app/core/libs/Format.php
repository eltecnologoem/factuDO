<?php

    class Format {

        // Dar fotmato a la fecha segun confg en Dash
        public static function date($string, $format = 'd, M Y'){
            $fecha = NULL;
            if(!empty($string) AND !empty($format)){
                $fecha = date($format, $string);        
            }
            
            return $fecha;
        }

        # Eliminar espacio para Color por Catgoria
        public static function ColorCat($string){
            
            $cat = self::RemoveAccents($string);
                    
            //Reemplazamos espacio por -
            $cat = str_replace(
                array(" ", "/"),
                array("-", "-"),
                $cat
            );
            
            $cat = strtolower($cat);
            return $cat.'-color';
        }

        # Retorna CAT traducida
        public static function LangCat($cat){
            switch($cat){
                case 'consoles':
                    $CatLang = App::$lang->cat->consoles;
                break;
                case 'raffles':
                    $CatLang = App::$lang->cat->raffles;
                break;
                case 'mobile':
                    $CatLang = App::$lang->cat->mobile;
                break;
                case 'technology':
                    $CatLang = App::$lang->cat->technology;
                break;
                case 'free games':
                    $CatLang = App::$lang->cat->free_games;
                break;
                case 'video games':
                    $CatLang = App::$lang->cat->video_games;
                break;
                case 'cine':
                    $CatLang = App::$lang->cat->cine;
                break;
                case 'xbox':
                    $CatLang = 'Xbox';
                break;
                case 'playstation':
                    $CatLang = 'PlayStation';
                break;
                case 'nintendo':
                    $CatLang = 'Nintendo';
                break;
                case 'pc':
                    $CatLang = 'PC';
                break;
            }
            if(!isset($CatLang)){
                $CatLang = NULL;
            }
                    
            return $CatLang;
        }

        # Eliminar acentos
        public static function RemoveAccents($cadena){
                        
            //Reemplazamos la A y a
            $cadena = str_replace(
                array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
                array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
                $cadena
            );
    
            //Reemplazamos la E y e
            $cadena = str_replace(
                array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
                array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
                $cadena 
            );
    
            //Reemplazamos la I y i
            $cadena = str_replace(
                array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
                array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
                $cadena
            );
        
            //Reemplazamos la O y o
            $cadena = str_replace(
                array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
                array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
                $cadena
            );
    
            //Reemplazamos la U y u
            $cadena = str_replace(
                array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
                array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
                $cadena
            );
    
            //Reemplazamos la N, n, C y c
            $cadena = str_replace(
                array('Ñ', 'ñ', 'Ç', 'ç'),
                array('N', 'n', 'C', 'c'),
                $cadena
            );
    
            //Reemplazamos la N, n, C y c
            $cadena = str_replace(
                array(" ", "/"),
                array("-", "-"),
                $cadena
            );
    
            $cadena = strtolower($cadena);
            
            return $cadena; 
        }

        public static function CatExists($cat){ // Validacion de si la categoria existe.

            $CatList = array(
                'xbox',
                'playstation',
                'nintendo',
                'consoles',
                'raffles',
                'pc',
                'mobile',
                'technology',
                'free-games',
                'video-games',
                'cine',
            );

            if(in_array($cat, $CatList)){
                return true;
                exit();
            } else {
                return false;
                exit();
            }

            return false;
            exit();
                    
        }

        public static function is_base64($base64){
            return (bool) preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $base64);
        }
    }

