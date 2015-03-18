<?php
/**
 * Created by PhpStorm.
 * User: Ruud
 * Date: 17-3-2015
 * Time: 10:06
 */

namespace Game\Routing;

class URI{

    private static $segments = array();

    /**
     *  Split the url in segments
     */
    public static function resolveSegments(){
        if(isset($_GET["url"])){
            $url = $_GET["url"];
            $u = explode("/", $url);
//            unset($u[0]);
            unset($u[count($u) - 1]);
            $u = array_values($u);
            self::$segments = $u;
        }
    }

    /**
     * @param $value
     * @return null
     * Return the specific segment.
     */
    public static function getSegment($value){
        if(isset(self::$segments[$value])){
            return self::$segments[$value];
        }
        return null;
    }
}