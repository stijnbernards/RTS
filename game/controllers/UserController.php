<?php
/**
 * Created by PhpStorm.
 * User: Ruud
 * Date: 17-3-2015
 * Time: 11:42
 */

use Game\Validating\Validator;
use Game\Request\CurlRequest;
use Game\Request\Redirect;

class UserController{

    public function Login(){
        $validator = new Validator(array(
            "email" => "required|min-value:1|max-value:255",
            "password" => "required|min-value:1|max-value:255"
        ), $_POST);
        $validator->check();

        if($validator->fails()){
            return Redirect::to("/login/", array("validator" => $validator, "input" => $_POST));
        }
        else{
            $request = new CurlRequest(REST_URL . "/Authenticate");
            $request->setData(array(
                "username" => $_POST["email"],
                "password" => $_POST["password"]
            ));
            $request->setOption(CURLOPT_CONNECTTIMEOUT, 5);
            $request->execute();

            $errors = array();
            $data = $request->getData();
            if($request->getResponseCode() == 200 && ($data !== null || $data !== false)){
                if(!$request->getError()){
                    if($response = json_decode($data)){
                        if(isset($response->hash)){
                            $_SESSION["user_hash"] = $response->hash;
                            return Redirect::to("/board/");
                        }
                    }
                    $errors[] = "Something went wrong.";
                }
            }

            if($data !== null){
                $errors[] = $data ? $data : "Something went wrong.";
            }

            if(count($errors) >= 1){
                return Redirect::to("/login/", array("errors" => $errors, "input" => $_POST));
            }
        }
        return Redirect::to("/");
    }
}