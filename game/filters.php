<?php
/**
 * Created by PhpStorm.
 * User: Ruud
 * Date: 17-3-2015
 * Time: 00:00
 */

use Game\Routing\Filter;

Filter::add("test", function($values = array()){
    if(isset($values[0]) && $values[0] == "test"){
        return true;
    }
    return false;
});