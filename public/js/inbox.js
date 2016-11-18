/**
 * Created by valentinlacour on 18/11/16.
 */
$(function(){

    /* this is only for demo. can be removed */
    function initMailboxAppDemo(){
        setTimeout(function(){
            $('#app-alert').removeClass('hide')
                .one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',function(){
                    $(this).removeClass('animated bounceInLeft');
                });
        }, 3000)
    }

    function initWysiwyg(){
        if(!$('div.tinymce').length)
            return false;
        tinymce.init({
            selector: 'div.tinymce',
            theme: 'inlite',
            plugins: 'link paste contextmenu autolink',
            insert_toolbar: '',
            selection_toolbar: 'bold italic | quicklink h3  blockquote',
            inline: true,
            paste_data_images: false,
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'
            ]
        });
    }

    function pageLoad(){

        initWysiwyg();

        initMailboxAppDemo();

        $('#message_file_input').css('display','none');
        $('#add_file_to_message').css('display','block');
    }
    $(".select2").each(function(){
        $(this).select2($(this).data());
    });
    pageLoad();
    SingApp.onPageLoad(pageLoad);

    $('#add_file_to_message').click(function(){
        $(this).fadeOut();
        $('#message_file_input').delay(350).fadeIn();
    });
});