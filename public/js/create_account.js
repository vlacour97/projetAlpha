/**
 * Created by antoine on 26/10/2016.
 */
$(function(){

    function pageLoad(){
        $('.widget').widgster();
    }

    pageLoad();
    SingApp.onPageLoad(pageLoad);

    $(".contratLink").click(function(e){
        e.preventDefault();
        $('#ContratModal').modal();
    });


});