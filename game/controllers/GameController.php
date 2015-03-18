<?php
/**
 * Created by PhpStorm.
 * User: Ruud
 * Date: 18-3-2015
 * Time: 20:20
 */

use Game\View;

class GameController{

    public function Main(){
        echo "test";
        View::render("game/game.html.twig", array());
    }
}