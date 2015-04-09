<?php
/**
 * Created by PhpStorm.
 * User: Ruud
 * Date: 23-3-2015
 * Time: 18:23
 */

class Town{

    public $id;
    public $name;
    public $resources;
    public $buildings;

    private $res1;
    private $res2;
    private $res3;

    public function __construct($data){
        $this->id = $data->ID;
        $this->name = $data->Name;
        $buildings = json_decode($data->Buildings);
        foreach($buildings as $building){
            $this->buildings[$building->id] = $building;
        }
        $this->res1 = $data->Res1;
        $this->res2 = $data->Res2;
        $this->res3 = $data->Res3;
        $this->resources = $this->getTownResources();
    }

    public function getTownResources(){
        $out = array();
        for($i = 1; $i <= 3; $i++){
            if($this->{"res" . $i} !== null){
                $resource = static::calculateResource($this->{"res" . $i}, $i);
                if($resource !== null){
                    $out[] = (object)array(
                        "type" => $resource->type,
                        "ammount" => $resource->ammount
                    );
                }
            }
        }
        return $out;
    }

    public static function calculateResource($ammount = 0, $type = null){
        if($type == null || $ammount <= 0) return null;

        return (object)array("type" => "Stone", "ammount" => $ammount);
    }

    public function getBuildingByName($name){
        $id = null;
        switch($name){
            case "townhall": $id = 0; break;
            case "temple": $id = 1; break;
            case "camp": $id = 2; break;
            case "workshop": $id = 3; break;
            case "farm": $id = 4; break;
            case "wall": $id = 5; break;
            case "storage_room": $id = 6; break;
            case "market": $id = 7; break;
            case "dock": $id = 8; break;
            case "airport": $id = 9; break;
            case "spaceport": $id = 10; break;
            case "university": $id = 11; break;
            case "barracks": $id = 12; break;
            case "vehicle_factory": $id = 13; break;
            case "energy_shield": $id = 14; break;
        }

        if($id !== null){
            if(isset($this->buildings[$id])){
                return $this->buildings[$id];
            }
        }
        return null;
    }
}