/**
 * Created by antoine on 26/10/2016.
 */
$(function(){

    var url = 'private/controller/survey/create_survey.php';

    function pageLoad(){
        $('.widget').widgster();
        init();
        events();
        var theme = 'air';
        var classes = 'messenger-fixed messenger-on-top';

        $.globalMessenger({ extraClasses: classes,theme: theme });
        Messenger.options = { extraClasses: classes,theme: theme  };

        updateValue()
    }

    pageLoad();
    SingApp.onPageLoad(pageLoad);


    function init(){
        $('.survey[data-id=1]').find('.rmvQuestion').removeClass('rmvAnswer').addClass('hidden');
        $('.answer[data-id=1]').find('.rmvAnswer').removeClass('rmvAnswer').addClass('hidden');
        $('.answer[data-id=2]').find('.rmvAnswer').removeClass('rmvAnswer').addClass('hidden');
    }

    function events(){
        $('body')
            .on('click','.addQuestion',function(){
                var $this = $(this);
                var id = $this.parent().parent().prev().data('id')+1;
                var urlTmp = url + '?action=get_survey_form&id=' + id;
                $.get(urlTmp)
                    .done(function(datas){
                        $this.parent().parent().before(datas);
                        init();
                    })
            })
            .on('click','.addAnswer',function(){
                var $this = $(this);
                var id_answer = $this.parent().parent().prev().data('id');
                var id_survey = $this.parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().data('id');
                var urlTmp = url + '?action=get_answer_form&id_survey=' + id_survey + '&id_answer=' +(id_answer+1);
                $.get(urlTmp)
                    .done(function(datas){
                        $this.parent().parent().before(datas);
                    })
            })
            .on('click','.rmvAnswer',function(){
                var id_survey = $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().data('id');
                $(this).parent().parent().remove();
                updateAnswers(id_survey);
            })
            .on('click','.rmvQuestion',function(){
                //var $group = $(this).parent().parent().parent().parent().parent().parent().parent().parent();
                //$group.remove();
                //updateQuestions();
                Messenger().post({
                    message: 'Vous ne pouvez pas supprimer cette question pour le moment',
                    type: 'error',
                    showCloseButton: true
                });
            })
            .on('change','.value',function(){
                updateValue();
            })
            .on('click','.SaveButton',function(e){
                e.preventDefault();
                if(verifData())
                    if($_GET('id') == "")
                        $('#SaveModal').modal();
                    else {
                        var urlTmp = url + '?action=save_survey&id=' + $_GET('id');
                        var form = $('form').serializeArray();
                        $.post(urlTmp, form)
                            .done(function (data) {
                                //TODO success
                            });
                    }
                else
                    Messenger().post({
                        message: error_message,
                        type: 'info',
                        showCloseButton: true
                    });
            })
            .on('click','.save_survey',function(e){
                var name;
                if((name = $('#question').val()) != ""){
                    var urlTmp = url + '?action=save_survey&name=' + name;
                    var form = $('form').serializeArray();
                    $.post(urlTmp,form)
                        .done(function(data){
                            //TODO success
                        })
                }else{
                    Messenger().post({
                        message: error_message2,
                        type: 'info',
                        showCloseButton: true
                    });
                }
            })
    }

    function updateValue(){
        var total = 0;
        $('.survey').each(function(index,element){
            var $element = $(element);
            var max = 0;
            $element.find('.answer .value').each(function(index,element){
                if(parseInt($(element).val()) > max)
                    max = $(element).val();
            });
            $element.find('.nb_point').html(max);
            total += parseInt(max);
        });
        $('.total_nb_point').html(total);
    }

    function verifData(){
        var response = true;
        $('.survey .value').each(function(index,element){
            if(!$.isNumeric($(element).val()))
                response = false;
        });
        $('.survey .response').each(function(index,element){
            if($(element).val() == "")
                response = false;
        });
        $('.survey .question-name').each(function(index,element){
            if($(element).val() == "")
                response = false;
        });
        return response;
    }

    function updateAnswers(id_Survey){
        var $this = $('.survey[data-id='+id_Survey+']');
        var iterator = 1;
        $this.find('.answer').each(function(index,element){
            var response = $(element).find('.response').val();
            var value = $(element).find('.value').val();
            var urlTmp = url + '?action=get_answer_form_with_args&response=' + response + '&value=' + value + '&id_survey=' + id_Survey + '&id_answer=' + iterator;
            $.get(urlTmp)
                .done(function(data){
                    $(element).replaceWith(data);
                    init();
                });
            iterator++;
        });
    }

    //TODO Mise à jour des questions
    function updateQuestions(){
        var iterator = 1;
        $('.survey').each(function(index,element){
            var name = $(element).find('.question-name').val();
            var urlTmp = url + '?action=get_survey_form_with_args&name=' + name + '&id=' + iterator;
            $.get(urlTmp)
                .done(function(data){
                    var data_answer = new Object();
                    data_answer.response = [];
                    data_answer.value = [];
                    $(element).find('.answer').each(function(index2,element2){
                        data_answer.response[index2] = $(element2).find('.response').val();
                        data_answer.value[index2] = $(element2).find('.value').val();
                    });
                    //$(element).replaceWith(data);
                    $('.survey[data-id='+ (index+1) +']').find('.answer').remove();
                    for(var i =0; i<data_answer.response.length;i++){
                        var urlTmp = url + '?action=get_answer_form_with_args&response=' + data_answer.response[i] + '&value=' + data_answer.value[i] + '&id_survey=' + iterator + '&id_answer=' + (i+1);
                        console.log(urlTmp);
                        $.get(urlTmp)
                            .done(function(datas){
                                $(element).find('.head_answer').after(datas);
                                console.log($(element).find('.answer[data-id='+ (i+1) +']'),datas);
                                init();
                            });
                    }
                    init();
                });
            iterator++;
        });
    }



    function $_GET(param) {
        var vars = {};
        window.location.href.replace( location.hash, '' ).replace(
            /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
            function( m, key, value ) { // callback
                vars[key] = value !== undefined ? value : '';
            }
        );

        if ( param ) {
            return vars[param] ? vars[param] : null;
        }
        return vars;
    }

});