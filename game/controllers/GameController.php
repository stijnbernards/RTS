<?php
/**
 * Created by PhpStorm.
 * User: Ruud
 * Date: 18-3-2015
 * Time: 20:20
 */

use Game\View;
use Game\Routing\URI;

class GameController{

    public function Main(){
        View::render("game/game.html.twig", array(
            "name" => "Geen stad",
            "resources" => array(
                "Total stone: 230",
                "Total wood: 3022",
                "Total population: 2303"
            ),
            "boarddata" => (object)array(
                "towns" => array(
                    (object)array(
                        "id" => 0,
                        "name" => "Dunno"
                    ),
                    (object)array(
                        "id" => 1,
                        "name" => "Pudding"
                    ),
                    (object)array(
                        "id" => 2,
                        "name" => "Banaan"
                    ),
                )
            )
        ));
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