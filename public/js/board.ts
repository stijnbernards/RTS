/**
 * Created by Ruud on 19-3-2015.
 */

///<reference path="town.ts" />
///<reference path="resource.ts" />

class Board {

    town:Town;
    towns: number[] = [];

    constructor() {
        this.town = null;
        this.initControls();
    }

    initControls(){
        var $this = this;
        jQuery(".town-left").on("click", function(){
            $this.changeTownByDirection(true);
        });

        jQuery(".town-right").on("click", function(){
            $this.changeTownByDirection(false);
        });

        jQuery(".towns > select").on("change", function(){
            $this.loadTown(jQuery(this).val());
        });

        jQuery(".world").on("click", function(){
            $this.mapView();
        });

        jQuery(".town-name").on("click", function(){
            if($this.town == null){
                var id = jQuery(".towns select option:first").val();
                if(id !== undefined){
                    $this.loadTown(id);
                }
            }
        });
    }

    loadUserData(){
        var data = JSON.parse(jQuery(".boarddata").text());
        this.towns = [];
        for(var i = 0; i < data.towns.length; i++){
            this.towns.push(data.towns[i].id);
        }
    }

    loadTown(id: number) {
        var $this = this,
            request = jQuery.ajax("/board/town/" + id + "/");

        request.always(function (data, status) {
            if(status == "success") {
                $this.resetContent();
                jQuery(".content").html(data);
                jQuery("body").addClass("town-view");

                var data = JSON.parse(jQuery(".content .town-data").text()),
                    town = new Town(data.id);

                if (data != null) {
                    town.name = data.name;

                    for (var i = 0; i < data.resources.length; i++) {
                        town.resources.push(new Resource(data.resources[i].type, data.resources[i].ammount));
                    }
                }
                $this.town = town;
                $this.updateTownData();
            }
        })
    }

    updateTownData(){
        var name = "No name",
            resources = "";

        if(this.town != null){
            name = this.town.name;
            for(var i = 0; i < this.town.resources.length; i++){
                resources += "<li>" + this.town.resources[i].type + ": " + this.town.resources[i].ammount + "</li>";
            }
        }

        jQuery(".town-name").text(name);
        jQuery(".town-resources").html(resources);
    }

    // true = left, false = right
    changeTownByDirection(direction: boolean){
        var id = null;

        if(this.towns.length >= 2) {
            if (direction) {
                id = this.towns[this.towns.indexOf(this.town.id) - 1];
                if (id == undefined) {
                    id = this.towns[this.towns.length - 1];
                }
            }
            else {
                id = this.towns[this.towns.indexOf(this.town.id) + 1];
                if (id == undefined) {
                    id = this.towns[0];
                }
            }
        }

        if(id != null && id >= 0){
            this.loadTown(id);
        }
    }

    mapView(){
        this.resetContent();
        jQuery(".content").html("<div class='world-map'></div>");
        jQuery(".world-map").draggable();
        jQuery("body").addClass("world-view");
        for(var i = 0; i < 10; i++){for(var j = 0; j < 10; j++){this.loadSegment(i, j); }}
    }

    loadSegment(x: number, y: number){
        if(jQuery("body").hasClass("world-view")) {
            var $this = this,
                request = jQuery.ajax("/board/map/segment/" + x + "/" + y + "/");

            request.always(function (data, status) {
                if (status == "success") {
                    jQuery(".world-map").append(data);
                }
            });
        }
    }

    resetContent(){
        this.town = null;
        jQuery(".town-resources").html("");
        jQuery(".town-name").html("No town");
        jQuery("body").attr("class", "");
    }
}

jQuery(document).ready(function () {
    var board = new Board();
    board.loadUserData();
    board.loadTown(jQuery(".towns > select > option:selected").val());
    window["board"] = board;
});