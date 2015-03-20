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
        //temp
        $towndata = "null";
        switch(URI::getSegment(2)){
            case 0:
                $towndata = json_encode((object)array(
                    "name" => "Dunno",
                    "id" => 0,
                    "resources" => array(
                        (object)array(
                            "type" => "Iron",
                            "ammount" => 1230
                        ),
                        (object)array(
                            "type" => "Wood",
                            "ammount" => 12230
                        ),
                        (object)array(
                            "type" => "Population",
                            "ammount" => 3230
                        )
                    )
                ));
                break;
            case 1:
                $towndata = json_encode((object)array(
                    "name" => "Pudding",
                    "id" => 1,
                    "resources" => array(
                        (object)array(
                            "type" => "Coal",
                            "ammount" => 1023
                        ),
                        (object)array(
                            "type" => "Wood",
                            "ammount" => 1220
                        ),
                        (object)array(
                            "type" => "Population",
                            "ammount" => 1230
                        )
                    )
                ));
                break;
            default:
                $towndata = json_encode((object)array(
                    "name" => "Banaan",
                    "id" => 2,
                    "resources" => array(
                        (object)array(
                            "type" => "Stone",
                            "ammount" => 10
                        ),
                        (object)array(
                            "type" => "Wood",
                            "ammount" => 120
                        ),
                        (object)array(
                            "type" => "Population",
                            "ammount" => 30
                        )
                    )
                ));
        }

        View::render("game/town.html.twig", array(
            "towndata" => $towndata,
            "buildings" => array(
                (object)array(
                    "name" => "Townhall",
                    "level" => 20,
                    "id" => 0
                ),
                (object)array(
                    "name" => "Temple",
                    "level" => 20,
                    "id" => 1
                ),
                (object)array(
                    "name" => "Camp",
                    "level" => 20,
                    "id" => 2
                ),
                (object)array(
                    "name" => "Workshop",
                    "level" => 20,
                    "id" => 3
                ),
                (object)array(
                    "name" => "Farm",
                    "level" => 20,
                    "id" => 4
                ),
                (object)array(
                    "name" => "Wall",
                    "level" => 20,
                    "id" => 5
                ),
                (object)array(
                    "name" => "Storage room",
                    "level" => 20,
                    "id" => 6
                ),
                (object)array(
                    "name" => "Market",
                    "level" => 20,
                    "id" => 7
                ),
                (object)array(
                    "name" => "Dock",
                    "level" => 20,
                    "id" => 8
                )
            )
        ));
    }

    public function TownHallOptions(){
        $request = new CurlRequest("http://192.168.0.178/Authenticate/");
        $request->setOption(CURLOPT_POST, 2);
        $request->setOption(CURLOPT_POSTFIELDS, "username=test&password=test");
        $request->execute();

        var_dump($request->getError());
        var_dump($request->getData());
        var_dump($request->getInfo());
//        View::render("game/buildings/townhall.html.twig", array());
    }

    public function CityOptions(){
    }
}