/**
 * Created by Ruud on 17-3-2015.
 */
// fix phpstorm error.
var jQuery = jQuery;
var City = (function () {
    function City() {
        this.modal = new Modal();
        this.initEvents();
    }
    City.prototype.initEvents = function () {
        var $this = this;
        jQuery(".building").on("click", function () {
            $this.modal.show();
            $this.modal.loadData("/city/building/" + jQuery(this).attr("id") + "/", {
                "test": "pudding"
            });
        });
    };
    return City;
})();
jQuery(document).ready(function () {
    window.city = new City();
});
//# sourceMappingURL=city.js.map