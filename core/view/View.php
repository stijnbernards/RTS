<?php
/**
 * Created by PhpStorm.
 * User: Ruud
 * Date: 17-3-2015
 * Time: 13:34
 */

namespace Game;

use Game\Request\Redirect;
use Twig_Environment;

use Twig_Loader_Filesystem;
use Twig_Filter_Function;
use Twig_SimpleFunction;

class View{

    private static $loader = null;
    private static $twig = null;

    private static function getTwig(){
        if(self::$loader == null){
            self::$loader = new Twig_Loader_Filesystem("game/views");
        }

        if(self::$twig == null){
            self::$twig = new Twig_Environment(self::$loader, array(
                "auto_reload" => true
            ));
        }

        self::$twig->addFilter("var_dump", new Twig_Filter_Function("var_dump"));
        self::$twig->addFunction(new Twig_SimpleFunction("generateCSRFToken", function(){
            $token = md5(uniqid(rand(), true));
            $_SESSION["csrf"][$token] = time();
            echo "<input type='hidden' value='" . $token . "' name='_token'/>";
        }));
        return self::$twig;
    }

    public static function render($name, $data = array()){
        $data["redirect"] = (object)array("data" => Redirect::getAllData());

        echo static::getTwig()->render("/" . $name, $data);
    }
}