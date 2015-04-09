<?php
/**
 * Created by PhpStorm.
 * User: Ruud
 * Date: 17-3-2015
 * Time: 00:00
 */

use Game\Routing\Filter;

Filter::add("no_auth", function($values = array()){
    if(!isset($_SESSION["user_hash"])){
        return true;
    }
    return false;
});

Filter::add("auth", function($values = array()){
    if(isset($_SESSION["user_hash"])){
        return true;
    }
    return false;
});

Filter::add("csrf", function($values = array()){
    if(!isset($_POST["_token"])){
        return false;
    }

    $token = $_POST["_token"];
    $expiration = time() - 86400;

    if(isset($_SESSION["csrf"]) && $_SESSION["csrf"] !== null && is_array($_SESSION["csrf"])){
        foreach($_SESSION["csrf"] as $key => $value){
            if($value < $expiration){
                unset($_SESSION["csrf"][$key]);
            }
        }
    }

    if(isset($_SESSION["csrf"][$token])){
        unset($_SESSION["csrf"][$token]);

        return true;
    }

    return false;
});