<?php
/**
 * Created by PhpStorm.
 * User: Ruud
 * Date: 17-3-2015
 * Time: 00:24
 */

namespace Game\Models;

use Game\Models\MongoDB;
use MongoId;

class Model{

    public $fields = array();
    public $collection = null;
    public $id = null;

    /**
     * Set all fields to null
     */
    public function __construct(){
        if(is_array($this->fields)){
            foreach($this->fields as $field){
                $this->$field = null;
            }
        }
    }

    /**
     * @return bool
     * Saves the model to the database.
     */
    public function save(){
        if(is_array($this->fields)){


            try{
                $col = MongoDB::getDatabase("RTS")->selectCollection($this->collection);

                $fields = array();
                foreach($this->fields as $value){
                    $fields[$value] = $this->$value;
                }

                if($col->findOne(array("_id" => new MongoId($this->id)))){
                    $col->update(array("_id" => new MongoId($this->id)), $fields);
                }
                else{
                    $col->insert((array) $fields);
                }
                return true;
            }
            catch(MongoException $e){
                http_response_code(500);
                die("Cannot connect to database");
            }
        }
        return false;
    }

    /**
     * @return bool
     * Deletes the document from the database.
     */
    public function delete(){
        if($this->id != null){
            return false;
        }

        if($this->collection !== null){
            try{
                MongoDB::getDatabase("RTS")->selectCollection($this->collection)->remove(array("_id" => new MongoId($this->id)));
            }
            catch(MongoException $e){
                http_response_code(500);
                die("Cannot connect to database");
            }
            return true;
        }
        return false;
    }

    /**
     * @param $query
     * @param null $callback
     * @return null
     * returns one value as Model Object
     */
    public static function findOne($query, $callback = null){
        $result = self::find($query, $callback, true);
        if(count($result) >= 1){
            return $result[0];
        }
        return null;
    }

    /**
     * @param $query
     * @param null $callback
     * @param bool $one
     * @return array
     * returns multiple values as Model Objects in a array
     */
    public static function find($query, $callback = null, $one = false){
        $class = get_called_class();
        $model = new $class();
        $collection = $model->collection;

        if($collection !== null){
            try{

                $col = MongoDB::getDatabase("RTS")->selectCollection($collection);

                $result = null;
                if($one){
                    $result = $col->findOne($query);
                }
                else{
                    $result = $col->find($query);
                }

                if($result !== null){
                    if($callback !== null){
                        $functions = call_user_func_array($callback, array(
                            $collection,
                            $result
                        ));
                    }

                    if($one){
                        $c = new $class();
                        $c->id = $result["_id"]->{'$id'};
                        foreach($c->fields as $field){
                            if(isset($result[$field])){
                                $c->$field = $result[$field];
                            }
                            else{
                                $c->$field = null;
                            }
                        }
                        return array($c);
                    }
                    else{
                        $out = array();
                        foreach($result as $document){
                            $c = new $class();
                            $c->id = $document["_id"]->{'$id'};
                            foreach($c->fields as $field){
                                if(isset($document[$field])){
                                    $c->$field = $document[$field];
                                }
                                else{
                                    $c->$field = null;
                                }
                            }
                            $out[] = $c;
                        }

                        return $out;
                    }
                }
            }
            catch(MongoException $e){
                http_response_code(500);
                die("Cannot connect to database");
            }
        }
        return array();
    }

    /**
     * @return array
     * returns all the documents in a collection
     */
    public static function findAll(){
        $class = get_called_class();
        $model = new $class();
        $collection = $model->collection;

        if($collection !== null){
            try{
                $results = MongoDB::getDatabase("RTS")->selectCollection($collection)->find(array());

                if($results != null && is_array($results)){
                    $out = array();
                    foreach($results as $document){

                        $c = new $class();
                        $c->id = $document["_id"]->{'$id'};
                        foreach($c->fields as $field){
                            if(isset($document[$field])){
                                $c->$field = $document[$field];
                            }
                            else{
                                $c->$field = null;
                            }
                        }
                        $out[] = $c;
                    }

                    return $out;
                }
            }
            catch(MongoException $e){
                http_response_code(500);
                die("Cannot connect to database");
            }
        }
        return array();
    }

    /**
     * @return bool
     * deletes all the values in a collection
     */
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
            return true;
        }
        return false;
    }

    /**
     * @param $model
     * Adds a new model to include the files.
     */
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