/**
 * Created by Ruud on 17-3-2015.
 */

///<reference path="modal.ts" />
///<reference path="resource.ts" />

class Town{

    modal: Modal;

    id: number;
    name: string;
    resources: Resource[] = [];

    constructor(id: number){
        this.modal = new Modal();
        this.id = id;
        this.name = "No name";
        this.initEvents();
    }

    initEvents(){
        var $this = this;
        jQuery(".building").on("click", function(){
            $this.modal.show();
            $this.modal.loadData("/board/town/building/" + jQuery(this).attr("id") + "/", {
                "test": "test"
            });
        });
    }
}
