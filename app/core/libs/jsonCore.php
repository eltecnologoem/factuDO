<?php

class json {

    public static function Create($data, $ruta){
        //self::rute($ruta);
        //if(!is_writable($ruta.'.json')){
        if(!is_writable(self::rute($ruta))){
            Alerts::Server('No writable. json::Create('.$ruta.'.json).');
            return false;
            exit();
        }
        
        $jsonencoded = json_encode($data, JSON_UNESCAPED_UNICODE);
        $fh = fopen($ruta.'.json', 'w');        
        fwrite($fh, $jsonencoded);       
        fclose($fh);
        unset($data, $ruta);
        return true;
    }

    public static function DataAdd($data, $ruta){
        if(!is_writable(self::rute($ruta))){
            Alerts::Server($ruta .'No writable json::DataAdd('.$ruta.'.json).');
            return false;
            exit();
        }
        
        $cdata = json::Get($ruta);
        $newD = array();

        foreach ($cdata as $old) {
            $newD[] = $old;
        }
        
        $newD[] = $data;

        $nData = array($cdata, $newD);
        $json = json_encode($newD, JSON_UNESCAPED_UNICODE);
        $fh = fopen($ruta.'.json', 'w');
        fwrite($fh, $json);
        fclose($fh);
        unset($data, $cdata, $ndata);
        return json::Get($ruta);
    }

    public static function Exists($ruta){
        if(file_exists($ruta.'.json')){
            return true;
        } else {
            return false;
        }
    }

    public static function Get($ruta){
        if(!self::Exists($ruta)){
            Alerts::Server('Not Exists. json::Get('.$ruta.'.json)');
            return false;
            exit();
        }

        $data = json_decode(file_get_contents($ruta.'.json'));
        return $data;
        exit();
    }

    public static function Delete($ruta){
        if(!self::Exists($ruta)){
            Alerts::Server('json::Delete(JsonFileNotExists).', 'warning');
            return false;
        }
        
        $rs = unlink($ruta.'.json');

        if($rs){
            return true;
            exit();
        } else {
            return false;
            exit();
        }

        return false;
        exit();
    }

    private static function rute($ruta){
        $rute = explode('/', $ruta);
        array_pop($rute);
        $rs = implode('/', $rute);
        return $rs;
        exit();
    }
    
}