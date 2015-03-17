<?php
/**
 * Created by PhpStorm.
 * User: Ruud
 * Date: 16-3-2015
 * Time: 23:32
 */

class TestController{

    public function GetHoi(){
        echo "get hoi :P";
    }

    public function PostHoi(){
        echo "post hoi :P";
    }

    public function ModelTest(){
        $model = TestModel::findAll();
        var_dump($model);
    }
}