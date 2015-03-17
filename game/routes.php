<?php
/**
 * Created by PhpStorm.
 * User: Ruud
 * Date: 16-3-2015
 * Time: 23:59
 */

use Game\Routing\Route;

Route::add(Route::GET, array(
    "url" => "/pudding/",
    "controller" => "TestController",
    "method" => "GetHoi",
    "filter" => "test:test"
));

Route::add(Route::POST, array(
    "url" => "/pudding/",
    "controller" => "TestController",
    "method" => "PostHoi",
    "filter" => "test:test"
));

Route::add(Route::GET, array(
    "url" => "/peer/",
    "view" => "page.html.twig",
    "data" => array("fruit" => "peer")
));

Route::add(Route::GET, array(
    "url" => "/appel/",
    "view" => "page.html.twig",
    "data" => array("fruit" => "appel")
));

Route::add(Route::GET, array(
    "url" => "/pudding/{?}/banaan/",
    "controller" => "TestController",
    "method" => "Hoi"
));

Route::add(Route::GET, array(
    "url" => "/model/",
    "controller" => "TestController",
    "method" => "ModelTest"
));