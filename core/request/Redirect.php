<?php
/**
 * Created by PhpStorm.
 * User: Ruud
 * Date: 23-3-2015
 * Time: 14:04
 */

namespace Game\Request;

class Redirect{

    private static $data = array();

    public static function to($url, $data = array()){
        $_SESSION["redirect_data"] = base64_encode(serialize($data));
        header("location: " . $url);
    }

    public static function getData($value){
        if(isset(static::$data[$value])){
            return static::$data[$value];
        }
        return null;
    }

    public static function getAllData(){
        return static::$data;
    }

    public static function resolveData(){
        if(isset($_SESSION["redirect_data"])){
            static::$data = unserialize(base64_decode($_SESSION["redirect_data"]));
            unset($_SESSION["redirect_data"]);
        }
    }
}