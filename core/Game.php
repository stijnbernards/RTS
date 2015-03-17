<?php
/**
 * Created by PhpStorm.
 * User: Ruud
 * Date: 16-3-2015
 * Time: 22:49
 */

namespace Game;

use Game\Routing\Router;
use Game\Routing\Route;
use Game\Routing\URI;
use Twig_Autoloader;

class Game{

    /**
     * Load all the required files and init Twig
     */
    public function __construct(){
        require_once 'libs/Twig/Autoloader.php';
        require_once "routing/Filter.php";
        require_once "routing/Route.php";
        require_once "routing/Router.php";
        require_once "routing/URI.php";

        require_once "models/MongoDB.php";
        require_once "models/Model.php";

        require_once "validating/Validator.php";

        require_once "request/CurlRequest.php";

        require_once "view/View.php";

        Twig_Autoloader::register();
    }


    /**
     * Start the game.
     */
    public function start(){
        require_once "game/loader.php";
        require_once "game/routes.php";
        require_once "game/filters.php";
        require_once "game/validators.php";

        URI::resolveSegments();

        $route = Route::resolveRoutes();
        if($route == null){
            http_response_code(404);
            die("Not found");
        }

        Router::executeRoutes($route);
    }
}