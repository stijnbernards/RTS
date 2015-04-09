/**
 * Created by Ruud on 17-3-2015.
 */

// fix phpstorm error.
var jQuery = jQuery;

class Modal{

    constructor(){
        jQuery(".modal").draggable();
        jQuery(".modal-options > .modal-close").on("click", function(){
            jQuery(this).closest(".modal").hide();
        });
        this.hide();
    }

    loadData(url: string, options: {}){
        var request = jQuery.ajax(url, options);
        request.always(function(data){
            jQuery(".modal > .modal-content").html(data);
        });
    }

    show(){
        jQuery(".modal").show();
    }

    hide(){
        jQuery(".modal").hide();
    }
}