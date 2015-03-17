/**
 * Created by Ruud on 17-3-2015.
 */

// fix phpstorm error.
var jQuery = jQuery;

class City{

    modal: Modal;

    constructor(){
        this.modal = new Modal();
        this.initEvents();
    }

    initEvents(){
        var $this = this;
        jQuery(".building").on("click", function(){
            $this.modal.show();
            $this.modal.loadData("/city/building/" + jQuery(this).attr("id") + "/", {
                "test": "pudding"
            });
        });
    }
}

jQuery(document).ready(function(){
    window.city = new City();
});
