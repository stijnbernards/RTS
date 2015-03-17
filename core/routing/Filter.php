<?php
/**
 * Created by PhpStorm.
 * User: Ruud
 * Date: 17-3-2015
 * Time: 00:02
 */

namespace Game\Routing;

class Filter{

    public static $filters = array();

    /**
     * @param $name
     * @param $callback
     * Add a filter to the filters
     */
    public static function add($name, $callback){
        static::$filters[$name] = $callback;
    }

    /**
     * @param $name
     * @param array $values
     * @return bool
     * Execute a filter and return the value
     */
    public static function executeFilter($name, $values = array()){
        if(array_key_exists($name, static::$filters) && is_callable(static::$filters[$name])){
            $method = call_user_func_array(static::$filters[$name], array($values));

            if($method){
                return true;
            }
            return false;
        }
        return false;
    }
}