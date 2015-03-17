<?php
/**
 * Created by PhpStorm.
 * User: Ruud
 * Date: 16-3-2015
 * Time: 22:56
 */

namespace Game\Routing;

class Route{

    const GET = "GET";
    const POST = "POST";

    private static $routes = array();
    public $method = null;
    public $url = null;
    public $options = null;

    /**
     * @param $method
     * @param $options
     * Create a new route.
     */
    public static function add($method, $options){
        if(!isset($options["url"])){
            return;
        }
        $route = new Route($method, $options);
        static::$routes[] = $route;
    }

    /**
     * @return null
     * Check what Route does match with the current URI and return it.
     */
    public static function resolveRoutes(){
        $url = "/";
        if(isset($_GET["url"])){
            $url = $_GET["url"];
        }

        $method = $_SERVER["REQUEST_METHOD"];

        $url_parts = explode("/", $url);
        unset($url_parts[0]);
        unset($url_parts[count($url_parts)]);
        $url_parts = array_values($url_parts);
        $url_length = count($url_parts);
        foreach(static::$routes as $route){

            if(!isset($route->method) || $route->method === null){
                continue;
            }

            if(!isset($route->url) || $route->url === null){
                continue;
            }

            if(!isset($route->options) || $route->options === null){
                continue;
            }

            if(!($method === $route->method)){
                continue;
            }

            $split = explode("/", $route->url);
            unset($split[0]);
            unset($split[count($split)]);
            $split = array_values($split);

            $total = count($split);
            $counter = 0;
            foreach($split as $index => $value){

                if(!isset($url_parts[$index])){
                    if(!($value === "{?}")){
                        break;
                    }
                    else{
                        $counter++;
                    }
                }
                else{
                    if($value == $url_parts[$index] || $value === "{?}"){
                        $counter++;
                    }
                }
            }

            if($total == $counter && $total == $url_length){
                return $route;
            }
        }
        return null;
    }

    public function __construct($method, $options){
        $this->method = $method;
        $this->url = $options["url"];
        $this->options = $options;
    }
}