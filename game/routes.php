<?php
/**
 * Created by PhpStorm.
 * User: Ruud
 * Date: 16-3-2015
 * Time: 23:59
 */

use Game\Routing\Route;

Route::add(Route::GET, array(
    "url" => "/",
    "view" => "login.html.twig",
    "filter" => "no_auth"
));
Route::add(Route::POST, array(
    "url" => "/login/",
    "controller" => "UserController",
    "method" => "Login",
    "filter" => "no_auth"
));

Route::add(Route::GET, array(
    "url" => "/city/",
    "controller" => "CityController",
    "method" => "View",
    "filter" => "auth"
));

Route::add(Route::GET, array(
    "url" => "/city/building/townhall/",
    "controller" => "CityController",
    "method" => "TownHallOptions",
    "filter" => "auth"
));
//Route::add(Route::GET, array(
//    "url" => "/pudding/",
//    "controller" => "TestController",
//    "method" => "GetHoi",
//    "filter" => "test:test"
//));
//
//Route::add(Route::POST, array(
//    "url" => "/pudding/",
//    "controller" => "TestController",
//    "method" => "PostHoi",
//    "filter" => "test:test"
//));
//
//Route::add(Route::GET, array(
//    "url" => "/peer/",
//    "view" => "page.html.twig",
//    "data" => array("fruit" => "peer")
//));
//
//Route::add(Route::GET, array(
//    "url" => "/appel/",
//    "view" => "page.html.twig",
//    "data" => array("fruit" => "appel")
//));
//
//Route::add(Route::GET, array(
//    "url" => "/pudding/{?}/banaan/",
//    "controller" => "TestController",
//    "method" => "Hoi"
//));
//
//Route::add(Route::GET, array(
//    "url" => "/model/",
//    "controller" => "TestController",
//    "method" => "ModelTest"
//));