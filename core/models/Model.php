<?php
/**
 * Created by PhpStorm.
 * User: Ruud
 * Date: 17-3-2015
 * Time: 00:24
 */

namespace Game\Models;

use Game\Models\MongoDB;

class Model{

    public $fields = array();
    public $collection = null;

    public function save(){

    }

    public function delete(){

    }

    public static function find($query){

    }

    public static function findAll(){
        $class = get_called_class();
        $model = new $class();
        $collection = $model->collection;

        if($collection !== null){
            try{
                $results = MongoDB::getDatabase("RTS")->selectCollection($collection)->find(array());
                var_dump($results);
                foreach($results as $document){
                    var_dump($document);
                }
            }
            catch(MongoException $e){
                http_response_code(500);
                die("Cannot connect to database");
            }
        }

        return array();
    }
    public static function deleteAll(){
        $class = get_called_class();
        $model = new $class();
        $collection = $model->collection;

        if($collection !== null){
            try{
                MongoDB::getDatabase("RTS")->selectCollection($collection)->remove(array());
            }
            catch(MongoException $e){
                http_response_code(500);
                die("Cannot connect to database");
            }
        }
    }

    public static function add($model){
        if(file_exists("game/models/" . $model . ".php")){
            require_once "game/models/" . $model . ".php";

            if(class_exists($model)){
                return;
            }
        }
        http_response_code(500);
        die("Model not found");
    }
}