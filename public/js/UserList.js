/**
 * Created by antoine on 05/11/2016.
 */
$(function(){

    var url = 'private/controller/user/user_list.php';
    var choice = "";
    var part = 1;
    var res;
    var currentLineId;
    var table;
    var infos_csv = new Object();
    var unchecked = true;
    var event8;
    infos_csv.nb_col = 0;
    infos_csv.nb_row = 0;

    function initDataTables(){
        /* Set the defaults for DataTables initialisation */
        $.extend( true, $.fn.dataTable.defaults, {
            "sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
            "sPaginationType": "bootstrap",
            "oLanguage": {
                "sLengthMenu": "_MENU_ enregistrements par page",
                "sEmptyTable" : "Aucune donnée dans ce tableau",
                "sSearch" :"Rechercher",
                "oPaginate": {
                    "sPrevious": "Précédent",
                    "sNext": "Suivant"
                }
            }
        } );


        /* Default class modification */
        $.extend( $.fn.dataTableExt.oStdClasses, {
            "sWrapper": "dataTables_wrapper form-inline"
        } );


        /* API method to get paging information */
        $.fn.dataTableExt.oApi.fnPagingInfo = function ( oSettings )
        {
            return {
                "iStart":         oSettings._iDisplayStart,
                "iEnd":           oSettings.fnDisplayEnd(),
                "iLength":        oSettings._iDisplayLength,
                "iTotal":         oSettings.fnRecordsTotal(),
                "iFilteredTotal": oSettings.fnRecordsDisplay(),
                "iPage":          oSettings._iDisplayLength === -1 ?
                    0 : Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength ),
                "iTotalPages":    oSettings._iDisplayLength === -1 ?
                    0 : Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength )
            };
        };


        /* Bootstrap style pagination control */
        $.extend( $.fn.dataTableExt.oPagination, {
            "bootstrap": {
                "fnInit": function( oSettings, nPaging, fnDraw ) {
                    var oLang = oSettings.oLanguage.oPaginate;
                    var fnClickHandler = function ( e ) {
                        e.preventDefault();
                        if ( oSettings.oApi._fnPageChange(oSettings, e.data.action) ) {
                            fnDraw( oSettings );
                        }
                    };

                    $(nPaging).append(
                        '<ul class="pagination no-margin">'+
                        '<li class="prev disabled"><a href="#">'+oLang.sPrevious+'</a></li>'+
                        '<li class="next disabled"><a href="#">'+oLang.sNext+'</a></li>'+
                        '</ul>'
                    );
                    var els = $('a', nPaging);
                    $(els[0]).bind( 'click.DT', { action: "previous" }, fnClickHandler );
                    $(els[1]).bind( 'click.DT', { action: "next" }, fnClickHandler );
                },

                "fnUpdate": function ( oSettings, fnDraw ) {
                    var iListLength = 5;
                    var oPaging = oSettings.oInstance.fnPagingInfo();
                    var an = oSettings.aanFeatures.p;
                    var i, ien, j, sClass, iStart, iEnd, iHalf=Math.floor(iListLength/2);

                    if ( oPaging.iTotalPages < iListLength) {
                        iStart = 1;
                        iEnd = oPaging.iTotalPages;
                    }
                    else if ( oPaging.iPage <= iHalf ) {
                        iStart = 1;
                        iEnd = iListLength;
                    } else if ( oPaging.iPage >= (oPaging.iTotalPages-iHalf) ) {
                        iStart = oPaging.iTotalPages - iListLength + 1;
                        iEnd = oPaging.iTotalPages;
                    } else {
                        iStart = oPaging.iPage - iHalf + 1;
                        iEnd = iStart + iListLength - 1;
                    }

                    for ( i=0, ien=an.length ; i<ien ; i++ ) {
                        // Remove the middle elements
                        $('li:gt(0)', an[i]).filter(':not(:last)').remove();

                        // Add the new list items and their event handlers
                        for ( j=iStart ; j<=iEnd ; j++ ) {
                            sClass = (j==oPaging.iPage+1) ? 'class="active"' : '';
                            $('<li '+sClass+'><a href="#">'+j+'</a></li>')
                                .insertBefore( $('li:last', an[i])[0] )
                                .bind('click', function (e) {
                                    e.preventDefault();
                                    oSettings._iDisplayStart = (parseInt($('a', this).text(),10)-1) * oPaging.iLength;
                                    fnDraw( oSettings );
                                } );
                        }

                        // Add / remove disabled classes from the static elements
                        if ( oPaging.iPage === 0 ) {
                            $('li:first', an[i]).addClass('disabled');
                        } else {
                            $('li:first', an[i]).removeClass('disabled');
                        }

                        if ( oPaging.iPage === oPaging.iTotalPages-1 || oPaging.iTotalPages === 0 ) {
                            $('li:last', an[i]).addClass('disabled');
                        } else {
                            $('li:last', an[i]).removeClass('disabled');
                        }
                    }
                }
            }
        } );

        var unsortableColumns = [];
        $('#user-table').find('thead th').each(function(){
            if ($(this).hasClass( 'no-sort')){
                unsortableColumns.push({"bSortable": false});
            } else {
                unsortableColumns.push(null);
            }
        });

        table = $("#user-table").DataTable({
            "sDom": "<'row'<'col-md-6 hidden-xs'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
            "oLanguage": {
                "sLengthMenu": "_MENU_",
                "sInfo": "Affichage de <strong>_START_ à _END_</strong> sur _TOTAL_ entrées"
            },
            "oClasses": {
                "sFilter": "pull-right",
                "sFilterInput": "form-control input-rounded ml-sm"
            },
            "aoColumns": unsortableColumns,
            ajax: url + '?action=get_table_datas'
        });

        $(".dataTables_length select").selectpicker({
            width: 'auto'
        });
    }

    function pageLoad(){
        $('.widget').widgster();
        var theme = 'air';
        var classes = 'messenger-fixed messenger-on-top';

        $.globalMessenger({ extraClasses: classes,theme: theme });
        Messenger.options = { extraClasses: classes,theme: theme  };
        initDataTables();
        events();
    }

    pageLoad();
    SingApp.onPageLoad(pageLoad);

    $('#wizard').bootstrapWizard({
        onTabShow: function($activeTab, $navigation, index) {
            var $total = $navigation.find('li').length;
            var $current = index + 1;
            var $percent = ($current/$total) * 100;
            var $wizard = $("#wizard");
            $wizard.find('.progress-bar').css({width: $percent + '%'});

            if($current >= $total) {
                $wizard.find('.pager .next').hide();
                $wizard.find('.pager .finish').show();
                $wizard.find('.pager .finish').removeClass('disabled');
            } else {
                $wizard.find('.pager .next').show();
                $wizard.find('.pager .finish').hide();
            }

            //setting done class
            $navigation.find('li').removeClass('done');
            $activeTab.prevAll().addClass('done');
        },

        // validate on tab change
        onNext: function($activeTab, $navigation, nextIndex){
            var $activeTabPane = $($activeTab.find('a[data-toggle=tab]').attr('href')),
                $form = $activeTabPane.find('form');

            // validate form in casa there is form
            if ($form.length){
                if($form.parsley().validate())
                {
                    //Deuxiéme page
                    if(nextIndex == 2){
                        switch (choice){
                            case 'hand':
                                var urlTmp = url + '?action=add_user_form_hand';
                                var datas = $('#step'+ nextIndex +' form').serializeArray();
                                $('.loader-wrap').removeClass('hide').removeClass('hiding');
                                $.post(urlTmp,datas)
                                    .done(function (datas) {
                                        datas = jQuery.parseJSON(datas);
                                        if(datas.response){
                                            $('#wizard').bootstrapWizard('show',nextIndex);
                                            table.ajax.reload( null, false );
                                        }else{
                                            Messenger().post({
                                                message: datas.exception,
                                                type: 'error',
                                                showCloseButton: true
                                            });
                                        }
                                        $('.loader-wrap').addClass('hide').addClass('hiding');
                                    });
                                break;
                            case 'csv':
                                if(part == 1){
                                    var urlTmp = url + '?action=upload_csv_file';
                                    var file = $("#csv")[0].files;
                                    var datas = new FormData();
                                    $.each(file, function(key, value)
                                    {
                                        datas.append(key, value);
                                    });
                                    infos_csv.nb_col = $('#nb_col').val();
                                    infos_csv.nb_row = $('#nb_row').val();
                                    datas.append('nb_col',infos_csv.nb_col);
                                    datas.append('nb_row',infos_csv.nb_row);
                                    $('.loader-wrap').removeClass('hide').removeClass('hiding');
                                    $.ajax({
                                        url: urlTmp,
                                        type: 'POST',
                                        data: datas,
                                        cache: false,
                                        dataType: 'json',
                                        processData: false, // Don't process the files
                                        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                                        success: function(datas, textStatus, jqXHR)
                                        {
                                            if(datas.response){
                                                $("#step2").html('<form><table class="table"><thead><tr class="selects"></tr></thead><tbody></tbody></table></form>');
                                                add_data(datas.data);
                                                add_attr(datas.attr);
                                                part = 2;
                                                res = [];
                                            }else{
                                                Messenger().post({
                                                    message: datas.exception,
                                                    type: 'error',
                                                    showCloseButton: true
                                                });
                                            }
                                            $('.loader-wrap').addClass('hide').addClass('hiding');
                                        }});
                                }else{
                                    var array = {'nb_col' : infos_csv.nb_col, nb_row : infos_csv.nb_row, data : res};
                                    var datas = new FormData();
                                    $.each(array, function(key, value)
                                    {
                                        datas.append(key, value);
                                    });
                                    var urlTmp = url + '?action=save_csv_list';
                                    $.ajax({
                                        url: urlTmp,
                                        type: 'POST',
                                        data: datas,
                                        cache: false,
                                        dataType: 'json',
                                        processData: false, // Don't process the files
                                        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                                        success: function(datas, textStatus, jqXHR)
                                        {
                                            if(!datas.response){
                                                var description = $("#step3 .description");
                                                description.html(datas.exception);
                                                if(datas.code == 2)
                                                    description.addClass('text-danger');
                                                else{
                                                    description.addClass('text-warning');
                                                    var tableException = "";
                                                    var items = datas.items;
                                                    console.log(datas.items);
                                                    if(items.student != null)
                                                        items.student.forEach(function(content2,key2){
                                                            tableException += "<tr class='bg-warning'><td>" + key2 + "</td><td>" + content2 + "</td></tr>";
                                                        });
                                                    if(items.ti != null)
                                                        items.ti.forEach(function(content2,key2){
                                                            tableException += "<tr class='bg-success'><td>" + key2 + "</td><td>" + content2 + "</td></tr>";
                                                        });
                                                    if(items.te != null)
                                                        items.te.forEach(function(content2,key2){
                                                            tableException += "<tr class='bg-info'><td>" + key2 + "</td><td>" + content2 + "</td></tr>";
                                                        });
                                                    $("#step3 table").html(tableException);
                                                }
                                                $("#step3 .error").removeClass('hidden');
                                                $("#step3 .success").addClass('hidden');
                                            }else{
                                                $("#step3 .success").removeClass('hidden');
                                                $("#step3 .error").addClass('hidden');
                                            }
                                            $('#wizard').bootstrapWizard('show',nextIndex);
                                            table.ajax.reload( null, false );
                                            $('.loader-wrap').addClass('hide').addClass('hiding');
                                        }});
                                }
                                break;
                        }
                    }
                }
                return false;
            }

        },
        //diable tab clicking
        onTabClick: function($activeTab, $navigation, currentIndex, clickedIndex){
            return false;
        },
        onPrevious : function($activeTab, $navigation, previousIndex){
            console.log(previousIndex);
            if(previousIndex == 1)
                return false;
            return true;
        }
    });

    function events() {
        $("body")
            .on('click', '.user', function (e) {
                e.preventDefault();
                var currentLineId = $(this).data('id');
                var urlTmp = url + '?action=get_user_infos&id=' + currentLineId;
                $.get(urlTmp)
                    .done(function (datas) {
                        $('#UserModal').modal();
                        $("#UserModal .modal-body").html(datas);
                    });
            })
            .on('click', '.change', function (e) {
                e.preventDefault();
                currentLineId = $(this).data('id');
                var urlTmp = url + '?action=get_edit_user_form&id=' + currentLineId;
                $.get(urlTmp)
                    .done(function (datas) {
                        $('#ChangeModal').modal();
                        $("#ChangeModal .modal-body").html(datas);
                        $("#ChangeModal .select2").each(function () {
                            $(this).select2($(this).data());
                        });
                    });
            })
            .on('click', '.delete_multiple', function () {
                var values = [];
                var checkedLines = $("#user-table input:checked[data-action!='check-all']");
                checkedLines.each(function (key, content) {
                    values[key] = $(content).data('id');
                });
                values.forEach(function (content) {
                    var urlTmp = url + '?action=delete_user&id=' + content;
                    $.get(urlTmp)
                        .done(function (datas) {
                            datas = jQuery.parseJSON(datas);
                            if (datas.response) {
                                $("input[data-id='" + content + "']").parent().parent().parent().addClass('selected');
                                table.row('.selected').remove().draw(false);
                            }
                            else {
                                switch (Math.floor(datas.code / 1000)) {
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
                })
            })
            .on('click', '#deleteLine', function () {
                var urlTmp = url + '?action=delete_user&id=' + currentLineId;
                $.get(urlTmp)
                    .done(function (datas) {
                        datas = jQuery.parseJSON(datas);
                        if (datas.response) {
                            $('#DeleteModal').modal('hide');
                            $("a[data-id='" + currentLineId + "']").parent().parent().addClass('selected');
                            table.row('.selected').remove().draw(false);
                        }
                        else {
                            switch (Math.floor(datas.code / 1000)) {
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
            })
            .on('click', '#user-table .delete', function (e) {
                e.preventDefault();
                currentLineId = $(this).data('id');
                $('#DeleteModal').modal();
            })
            .on('click', '#wizard .finish button', function (e) {
                $('#AddStudentModal').modal('hide');
                $('#wizard').delay(200).bootstrapWizard('show', 0);
                $('#addByCSV').removeClass('text-danger');
                $('#addByHand').removeClass('text-danger');
                choice = "";
                part = 1;
            })
            .on('click', '.add_user_and_student', function (e) {
                e.preventDefault();
                $('#AddStudentModal').modal();
            })
            .on('click', '#addByHand', function () {
                $(this).addClass('text-danger');

                var urlTmp = url + '?action=get_add_user_form_hand';
                $.get(urlTmp)
                    .done(function (datas) {
                        $('.next button').removeAttr('disabled');
                        $('#addByCSV').removeClass('text-danger');
                        $("#step2").html(datas);
                        $("#step2 .select2").each(function () {
                            $(this).select2($(this).data());
                        });
                        $('#add_student_birthdate').datetimepicker({
                            pickTime: false
                        });
                        $('#add_student_deathdate').datetimepicker({
                            pickTime: false
                        });
                        choice = "hand";
                    })
            })
            .on('click', '#addByCSV', function () {
                $(this).addClass('text-danger');
                $('.next button').removeAttr('disabled');
                $('#addByHand').removeClass('text-danger');
                $("#step2").html($('#CSVForm').html());
                choice = 'csv';
                part = 1;
            })
            .on('click', '#change-submit', function(e){
                e.preventDefault();
                var urlTmp = url + '?action=change_user&id=' + currentLineId;
                var form = $("#ChangeModal .modal-body form").serializeArray();
                $.post(urlTmp,form)
                    .done(function (datas) {
                        datas = jQuery.parseJSON(datas);
                        if (datas.response) {
                            $('#ChangeModal').modal('hide');
                            table.ajax.reload( null, false );
                        }
                        else {
                            switch (Math.floor(datas.code / 1000)) {
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
    }

    $("#check-all").click(function(){
        if(unchecked)
            $("#user-table input[type='checkbox']").prop('checked',1);
        else
            $("#user-table input[type='checkbox']").prop('checked',false);
        unchecked = !unchecked;
    });

    function add_data(data){
        var flag_head = true;

        for(var rows in data) {

            $('#step2 tbody').append('<tr>');

            data[rows].forEach(function(cols,key){

                $('tbody').append('<td>'+cols+'</td>');

                if(flag_head){
                    $('.selects').append('<td><select class="select2 form-control csv" tabindex="-1" id="'+key+'"></select></td>');
                }

            });

            flag_head = false;
            $('#step2 tbody').append('</tr>');
        }
    }

    function add_attr(data){
        for(var element in data) {
            if((typeof data[element] === "object") && (data[element] !== null)){
                $('#step2 select').append('<optgroup label="'+data[element].name+'">');
                for(var element2 in data[element].attr) {
                    $('#step2 select').append('<option value="'+element+'/'+element2+'">'+data[element].attr[element2]+'</option>');
                }
                $('#step2 select').append('</optgroup');
            }else{
                $('#step2 select').append('<optgroup label="Autre"><option selected>'+data[element]+'</option></optgroup>');
            }
        }

        $('#step2 select').change(function(){
            res[$(this).attr('id')] = $(this).val();
            $('#step2 option').prop('disabled',false);
            res.forEach(function(value){
                if(value != 'other')
                    $('#step2 option[value="'+value+'"]').prop('disabled',true);
            });
        });
    }

});