/**
 * Created by antoine on 26/10/2016.
 */
$(function(){

    function pageLoad(){
        $('.widget').widgster();
    }

    pageLoad();
    SingApp.onPageLoad(pageLoad);

    $(".addComment").click(function(e){
       $(this).addClass('hidden').parent().children('div').removeClass('hidden');
    });

    $(".closeComment").click(function(e){
       $(this).parent().parent().parent().children('div').addClass('hidden').parent().children('button').removeClass('hidden');
    });


    $(".HelpButton").click(function(e){
        e.preventDefault();
        $('#HelpModal').modal();
    });

    $(".SaveButton").click(function(e){
        e.preventDefault();
        $('#SaveModal').modal();
    });
 
});