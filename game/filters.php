<?php
/**
 * Created by PhpStorm.
 * User: Ruud
 * Date: 17-3-2015
 * Time: 00:00
 */

use Game\Routing\Filter;

Filter::add("no_auth", function($values = array()){
    if(!isset($_SESSION["user"])){
        return true;
    }
    return false;
});

Filter::add("auth", function($values = array()){
    return true;
});