<?php
/**
 * Created by PhpStorm.
 * User: Ruud
 * Date: 17-3-2015
 * Time: 11:42
 */

use Game\Validating\Validator;
use Game\Request\CurlRequest;

class UserController{

    public function Login(){
        var_dump($_POST);

        $validator = new Validator(array(
            "email" => "required",
            "password" => "required"
        ), $_POST);
        $validator->check();

        if($validator->fails()){
            var_dump("FAILUER");
        }
        else{
            var_dump(REST_URL . "");
            $request = new CurlRequest(REST_URL . "");
            $request->setOption(CURLOPT_CONNECTTIMEOUT, 5);
            $request->execute();

            var_dump($request->getData());
            var_dump($request->getResponseCode());
            var_dump($request->getError());
        }
        var_dump($validator);

    }
}