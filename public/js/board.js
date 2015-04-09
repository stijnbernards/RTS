/**
 * Created by Ruud on 19-3-2015.
 */
///<reference path="town.ts" />
///<reference path="resource.ts" />
var Board = (function () {
    function Board() {
        this.towns = [];
        this.town = null;
        this.initControls();
    }
    Board.prototype.initControls = function () {
        var $this = this;
        jQuery(".town-left").on("click", function () {
            $this.changeTownByDirection(true);
        });
        jQuery(".town-right").on("click", function () {
            $this.changeTownByDirection(false);
        });
        jQuery(".towns > select").on("change", function () {
            $this.loadTown(jQuery(this).val());
        });
        jQuery(".world").on("click", function () {
            $this.mapView();
        });
        jQuery(".town-name").on("click", function () {
            if ($this.town == null) {
                var id = jQuery(".towns select option:first").val();
                if (id !== undefined) {
                    $this.loadTown(id);
                }
            }
        });
    };
    Board.prototype.loadUserData = function () {
        var data = JSON.parse(jQuery(".boarddata").text());
        this.towns = [];
        for (var i = 0; i < data.towns.length; i++) {
            this.towns.push(data.towns[i].id);
        }
    };
    Board.prototype.loadTown = function (id) {
        var $this = this, request = jQuery.ajax("/board/town/" + id + "/");
        request.always(function (data, status) {
            if (status == "success") {
                $this.resetContent();
                jQuery(".content").html(data);
                jQuery("body").addClass("town-view");
                var data = JSON.parse(jQuery(".content .town-data").text()), town = new Town(data.id);
                if (data != null) {
                    town.name = data.name;
                    for (var i = 0; i < data.resources.length; i++) {
                        town.resources.push(new Resource(data.resources[i].type, data.resources[i].ammount));
                    }
                }
                $this.town = town;
                $this.updateTownData();
            }
        });
    };
    Board.prototype.updateTownData = function () {
        var name = "No name", resources = "";
        if (this.town != null) {
            name = this.town.name;
            for (var i = 0; i < this.town.resources.length; i++) {
                resources += "<li>" + this.town.resources[i].type + ": " + this.town.resources[i].ammount + "</li>";
            }
        }
        jQuery(".town-name").text(name);
        jQuery(".town-resources").html(resources);
    };
    // true = left, false = right
    Board.prototype.changeTownByDirection = function (direction) {
        var id = null;
        if (this.towns.length >= 2) {
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
        if (id != null && id >= 0) {
            this.loadTown(id);
        }
    };
    Board.prototype.mapView = function () {
        this.resetContent();
        jQuery(".content").html("<div class='world-map'></div>");
        jQuery(".world-map").draggable();
        jQuery("body").addClass("world-view");
        for (var i = 0; i < 10; i++) {
            for (var j = 0; j < 10; j++) {
                this.loadSegment(i, j);
            }
        }
    };
    Board.prototype.loadSegment = function (x, y) {
        if (jQuery("body").hasClass("world-view")) {
            var $this = this, request = jQuery.ajax("/board/map/segment/" + x + "/" + y + "/");
            request.always(function (data, status) {
                if (status == "success") {
                    jQuery(".world-map").append(data);
                }
            });
        }
    };
    Board.prototype.resetContent = function () {
        this.town = null;
        jQuery(".town-resources").html("");
        jQuery(".town-name").html("No town");
        jQuery("body").attr("class", "");
    };
    return Board;
})();
jQuery(document).ready(function () {
    var board = new Board();
    board.loadUserData();
    board.loadTown(jQuery(".towns > select > option:selected").val());
    window["board"] = board;
});
//# sourceMappingURL=board.js.map