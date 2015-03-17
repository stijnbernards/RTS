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

    /**
     * @param $db
     * Connect to the mongodb
     */
    private static function connect($db){
        $user = "admin:game_password@";
        self::$connection = new MongoClient("mongodb://" . $user . "192.168.0.11" . ":" . "2729" . "/" . $db);
    }

    /**
     * @param $db
     * @return null
     * return the connection
     */
    public function getConnection($db){
        if(self::$connection == null){
            self::connect($db);
        }
        return self::$connection;
    }

    /**
     * @param $db
     * @return mixed
     * return the database
     */
    public function getDatabase($db){
        if(self::$connection == null){
            self::connect($db);
        }
        return self::$connection->selectDB($db);
    }
}