<?php
/**
 * Created by PhpStorm.
 * User: Ruud
 * Date: 17-3-2015
 * Time: 11:46
 */

use Game\Validating\Validator;

    Validator::add("required", function ($value, $parameters = array()){
        if($value !== null){
            return true;
        }

        return false;
    });
    Validator::addMessage("required", "Dit veld is verplicht");

    Validator::add("int", function ($value, $parameters = array()){
        if(is_int($value)){
            return true;
        }

        return false;
    });
    Validator::addMessage("int", "Dit moet een nummer zijn.");

    Validator::add("min", function ($value, $parameters = array()){
        if(count($parameters) >= 1){
            if(intval($value) >= $parameters[0]){
                return true;
            }
        }

        return false;
    });

    Validator::add("max", function ($value, $parameters = array()){
        if(count($parameters) >= 1){
            if(intval($value) <= $parameters[0]){
                return true;
            }
        }

        return false;
    });

    Validator::add("min-value", function ($value, $parameters = array()){
        if(count($parameters) >= 1){
            if(strlen($value) >= $parameters[0]){
                return true;
            }
        }

        return false;
    });
    Validator::addMessage("min-value", "{key} moet meer zijn dan {parameter_0}");

    Validator::add("max-value", function ($value, $parameters = array()){
        if(count($parameters) >= 1){
            if(strlen($value) <= $parameters[0]){
                return true;
            }
        }

        return false;
    });

    Validator::add("telephone", function ($value, $parameters = array()){
        if(preg_match('/^0[1-68]([ .-]?[0-9]{2}){4}$/', $value)){
            return true;
        }

        return false;
    });

    Validator::add("email", function ($value, $parameters = array()){
        if(preg_match('/^([\w\.\-_]+)?\w+@[\w-_]+(\.\w+){1,}$/', $value)){
            return true;
        }

        return false;
    });

    Validator::add("url", function ($value, $parameters = array()){
        if(preg_match('/^(http(s)?):\/\/[(www\.)?a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&\/\/=]*)+$/', $value)){
            return true;
        }

        return false;
    });

    Validator::add("double", function ($value, $parameters = array()){
        if(is_double($value)){
            return true;
        }

        return false;
    });

    Validator::add("equals", function ($value, $parameters = array()){
        if(count($parameters) >= 1){
            $options = explode(",", $parameters[0]);
            foreach($options as $option){
                if($value === $option){
                    return true;
                }
            }
        }

        return false;
    });

    Validator::add("alpha_num", function ($value, $parameters = array()){
        if(preg_match('/^[A-Za-z0-9_-]+$/', $value)){
            return true;
        }

        return false;
    });