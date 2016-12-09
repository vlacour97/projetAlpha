/**
 * Created by valentinlacour on 24/11/16.
 */

$(function(){
    function pageLoad(){

        $('.widget').widgster();
        var theme = 'air';
        var classes = 'messenger-fixed messenger-on-top';

        $.globalMessenger({ extraClasses: classes,theme: theme });
        Messenger.options = { extraClasses: classes,theme: theme  };

    }
    pageLoad();
    SingApp.onPageLoad(pageLoad);

    $('#submit').click(function(e){

        e.preventDefault();
        var url = "private/controller/login.php";
        var form = $('form').serializeArray();
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