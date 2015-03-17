<?php
/**
 * Created by PhpStorm.
 * User: Ruud
 * Date: 17-3-2015
 * Time: 13:34
 */

namespace Game;

use Twig_Environment;

use Twig_Loader_Filesystem;

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

        return self::$twig;
    }

    public static function render($name, $data = array()){
        echo static::getTwig()->render("/" . $name, $data);
    }
}