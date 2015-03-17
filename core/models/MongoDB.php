<?php
/**
 * Created by PhpStorm.
 * User: Ruud
 * Date: 17-3-2015
 * Time: 00:37
 */

namespace Game\Models;

use MongoClient;

class MongoDB{

    private static $connection = null;
    private static $database = null;

    private static function connect($db){

        $user = "admin:game_password@";
        static::$connection = new MongoClient("mongodb://" . $user . "192.168.0.11" . ":" . "2729" . "/" . $db);
        static::$database = static::$connection->selectDB($db);
    }

    public function getConnection($db){
        if(static::$connection == null){
            static::connect($db);
        }
        return static::$connection;
    }

    public function getDatabase($db){
        if(static::$database == null){
            static::connect($db);
        }
        return static::$database;
    }
}