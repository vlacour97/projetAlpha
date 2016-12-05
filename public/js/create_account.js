/**
 * Created by antoine on 26/10/2016.
 */
$(function(){

    function pageLoad(){
        $('.widget').widgster();
        var theme = 'air';
        var classes = 'messenger-fixed messenger-on-top';

        $.globalMessenger({ extraClasses: classes,theme: theme });
        Messenger.options = { extraClasses: classes,theme: theme  };
    }

    var disabled = $('input[value!=""][type!="checkbox"]');

    disabled.attr('disabled','true');

    pageLoad();
    SingApp.onPageLoad(pageLoad);

    $('#submit').click(function(e){

        e.preventDefault();
        var url = "private/controller/active_user.php";
        disabled.removeAttr('disabled');;
        var form = $('form').serializeArray();
        disabled.attr('disabled','true');
        $.post(url,form)
            .done(function(datas){
                datas = jQuery.parseJSON(datas);
                if(datas.response)
                    document.location.href="index.php";
                else
                {
                    switch (Math.floor(datas.code/1000)){
                        case 2 :
                            error = 'info';
                            break;
                        default :
                            error = 'error';
                    }
                    Messenger().post({
                        message: datas.exception,
                        type: error,
                        showCloseButton: true
                    });
                }
            });

    });



});