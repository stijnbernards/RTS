<?php
/**
 * Created by PhpStorm.
 * User: Ruud
 * Date: 17-3-2015
 * Time: 13:32
 */

use Game\View;
use Game\Routing\URI;
use Game\Request\CurlRequest;

class TownController{

    public function ViewTown(){
        $id = URI::getSegment(2);
        if($id == null && !is_integer($id)){
            return;
        }

        $request = new CurlRequest(REST_URL . "/Towndata/" . $id . "/all");
        $request->setHash();
        $request->setOption(CURLOPT_CONNECTTIMEOUT, 5);
        $request->execute();

        if($request->getResponseCode() == 200 && !$request->getError() && $request->getData()){

            if($data = json_decode($request->getData())){
                $towndata = null;
                $town = new Town($data);
                $towndata = json_encode((object)array(
                    "name" => $town->name,
                    "id" => $town->id,
                    "resources" => $town->resources
                ));

                if($towndata !== null){
                    View::render("game/town.html.twig", array(
                        "towndata" => $towndata,
                        "buildings" => $town->buildings
                    ));
                }
            }
        }
    }

    public function TownHallOptions(){
//        $request = new CurlRequest("http://192.168.0.178/Authenticate/");
//        $request->setOption(CURLOPT_POST, 2);
//        $request->setOption(CURLOPT_POSTFIELDS, "username=test&password=test");
//        $request->execute();
//
//        var_dump($request->getError());
//        var_dump($request->getData());
//        var_dump($request->getInfo());
//        View::render("game/buildings/townhall.html.twig", array());
    }

    public function CityOptions(){
    }
}