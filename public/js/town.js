/**
 * Created by Ruud on 17-3-2015.
 */
///<reference path="modal.ts" />
///<reference path="resource.ts" />
var Town = (function () {
    function Town(id) {
        this.resources = [];
        this.modal = new Modal();
        this.id = id;
        this.name = "No name";
        this.initEvents();
    }
    Town.prototype.initEvents = function () {
        var $this = this;
        jQuery(".building").on("click", function () {
            $this.modal.show();
            $this.modal.loadData("/board/town/building/" + jQuery(this).attr("id") + "/", {
                "test": "test"
            });
        });
    };
    return Town;
})();
//# sourceMappingURL=town.js.map