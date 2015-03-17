<?php
/**
 * Created by PhpStorm.
 * User: Ruud
 * Date: 16-3-2015
 * Time: 23:32
 */

use Game\Routing\URI;

class TestController{

    public function GetHoi(){
        echo "get hoi :P";
    }

    public function PostHoi(){
        echo "post hoi :P";
    }

    public function ModelTest(){
//        $model = TestModel::findOne(array(), function($collection, $result){
////            $result->skip(1);
//        });

//        $model = new TestModel();
//        if($model !== null){
//            $model->username = "tespudingdingter";
//            $model->save();
//        }
//        var_dump($model);

        var_dump(URI::getSegment(0));
        TestModel::deleteAll();
    }
}