<?php
/**
 * Created by PhpStorm.
 * User: Ruud
 * Date: 18-3-2015
 * Time: 20:20
 */

use Game\View;
use Game\Routing\URI;
use Game\Request\CurlRequest;
use Game\Request\Redirect;

class GameController{

    public function Main(){
        $request = new CurlRequest(REST_URL . "/Towndata/user");
        $request->setHash();
        $request->setOption(CURLOPT_CONNECTTIMEOUT, 5);

        if(!DEBUG){
            $request->execute();
        }

        if($request->getResponseCode() == 200 && !$request->getError() && $request->getData() || DEBUG){

            if($data = json_decode($request->getData()) || DEBUG){
                if(DEBUG){
                    $towns = array(
                        (object)array(
                            "id" => 4,
                            "name" => "peter"
                        ),
//                        (object)array(
//                            "id" => 1,
//                            "name" => "Pudding"
//                        ),
//                        (object)array(
//                            "id" => 2,
//                            "name" => "Banaan"
//                        ),
                    );
                }
                else{
                    $towns = array();
                    foreach($data as $town){
                        $towns[] = (object)array(
                            "id" => $town->id,
                            "name" => $town->name
                        );
                    }
                }

                View::render("game/game.html.twig", array(
                    "name" => "Geen stad",
                    "resources" => array(
                        "Total stone: 230",
                        "Total wood: 3022",
                        "Total population: 2303"
                    ),
                    "boarddata" => (object)array(
                        "towns" => $towns
                    )
                ));
                return;
            }
        }
        return Redirect::to("/");
    }

    public function LoadMapSegment(){
        $x = URI::getSegment(3);
        $y = URI::getSegment(4);
        ?>
        <div class="world-segment t1" style="top: <?php echo $y * 1000 ?>px; left: <?php echo $x * 1000 ?>px;">
            segment <?php echo $x . ", " . $y; ?>
        </div>
    <?php
    }
}