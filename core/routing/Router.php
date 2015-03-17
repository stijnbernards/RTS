<?php
/**
 * Created by PhpStorm.
 * User: Ruud
 * Date: 16-3-2015
 * Time: 22:49
 */

namespace Game\Routing;
use Twig_Environment;
use Twig_Loader_Filesystem;

class Router{

    /**
     * @param Route $route
     * Execute the controller or view for the specific route.
     */
    public static function executeRoutes(Route $route){
        if($route !== null){

            $method = $_SERVER["REQUEST_METHOD"];

            if(isset($route->method)){
                if(!($route->method == $method)){
                    http_response_code(405);
                    die("Method not allowed");
                }
            }

            if(isset($route->options)){

                $options = (object)$route->options;

                if(isset($options->filter)){
                    $filters = explode("|", $options->filter);
                    $total_filters = count($filters);
                    $done_filters = 0;
                    $errors = array();

                    foreach($filters as $key => $value){
                        $opt = explode(":", $value);
                        $apt = $opt;
                        unset($opt[0]);
                        $opt = array_values($opt);

                        if(Filter::executeFilter($apt[0], $opt)){
                            $done_filters++;
                            continue;
                        }
                        $errors[] = $apt[0];
                    }

                    if(!($done_filters == $total_filters)){
                        http_response_code(404);
                        $e = "";
                        foreach($errors as $error){
                            $e .= $error . "<br />";
                        }
                        die($e);
                    }
                }

                if(isset($options->controller) && isset($options->method)){
                    $path = "game/controllers/" . $options->controller . ".php";

                    if(!file_exists($path)){
                        http_response_code(404);
                        die(404);
                    }

                    require_once $path;

                    if(!class_exists($options->controller)){
                        http_response_code(404);
                        die(404);
                    }
                    $controller = new $options->controller();

                    if(!method_exists($controller, $options->method)){
                        http_response_code(404);
                        die(404);
                    }

                    $controller->{$options->method}();
                    return;
                }

                if(isset($options->view)){
                    $loader = new Twig_Loader_Filesystem("game/views");
                    $twig = new Twig_Environment($loader, array(
                        "auto_reload" => true
                    ));

                    $data = array();
                    if(isset($options->data) && is_array($options->data)){
                        $data = $options->data;
                    }
                    echo $twig->render($options->view, $data);
                }

            }
        }
    }
}