<?php
/**
 * Created by PhpStorm.
 * User: Ruud
 * Date: 17-3-2015
 * Time: 00:27
 */

use Game\Models\Model;

if(!defined("REST_URL")){
    define("REST_URL", "192.168.0.178");
}

if(!defined("DEBUG")){
    define("DEBUG", true);
}

require_once "helpers/Town.php";
//Model::add("UserModel");