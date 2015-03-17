/**
 * Created by Ruud on 17-3-2015.
 */
// fix phpstorm error.
var jQuery = jQuery;
var Modal = (function () {
    function Modal() {
        jQuery(".modal-options > .modal-close").on("click", function () {
            jQuery(this).closest(".modal").hide();
        });
        this.hide();
    }
    Modal.prototype.loadData = function (url, options) {
        var request = jQuery.ajax(url, options);
        request.always(function (data) {
            jQuery(".modal > .modal-content").html(data);
        });
    };
    Modal.prototype.show = function () {
        jQuery(".modal").show();
    };
    Modal.prototype.hide = function () {
        jQuery(".modal").hide();
    };
    return Modal;
})();
//# sourceMappingURL=modal.js.map