/**
 * Created by antoine on 05/11/2016.
 */
$(function(){

    var currentLineId;
    var table;

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
            "aoColumns": unsortableColumns
        });

        $(".dataTables_length select").selectpicker({
            width: 'auto'
        });
    }

    function pageLoad(){
        $('.widget').widgster();
        initDataTables();
    }

    pageLoad();
    SingApp.onPageLoad(pageLoad);

    $(".user").click(function(e){
        e.preventDefault();
        $('#UsersModal').modal();
    });

    $(".student").click(function(e){
        e.preventDefault();
        $('#StudentsModal').modal();
    });

    $(".change").click(function(e){
        e.preventDefault();
        currentLineId = $(this).data('id');
        $('#ChangeModal').modal();
    });
    $(".delete").click(function(e){
        e.preventDefault();
        currentLineId = $(this).data('id');
        $('#DeleteModal').modal();
    });

    $(".add_user_and_student").click(function(e){
        e.preventDefault();
        $('#AddStudentModal').modal();
    });

    $(".ImportStudent").click(function(e){
        e.preventDefault();
        $('#ImportModal').modal();
    });

    var wizard = $('#wizard').bootstrapWizard({
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
                return $form.parsley().validate();
            }
        },
        //diable tab clicking
        onTabClick: function($activeTab, $navigation, currentIndex, clickedIndex){
            return false;
        }
    });

    $(".select2").each(function(){
        $(this).select2($(this).data());
    });


    $('#addByCSV').click(function(){
        $(this).addClass('text-danger');
        $('.next button').removeAttr('disabled');
        $('#addByHand').removeClass('text-danger');
        $("#step2").html($('#CSVForm').html());
    });

    $('#addByHand').click(function(){
        $(this).addClass('text-danger');
        $('.next button').removeAttr('disabled');
        $('#addByCSV').removeClass('text-danger');
        $("#step2").html($('#HandForm').html());
        $(".select2").each(function(){
            $(this).select2($(this).data());
        });
        $('#add_student_birthdate').datetimepicker({
            pickTime: false
        });
    });
    
    $('#deleteLine').click(function() {
        $('#DeleteModal').modal('hide');
        $("a.delete[data-id="+currentLineId+"]").parent().parent().addClass('selected');
        table.row('.selected').remove().draw( false );
    });

    $('[data-toggle="tooltip"]').tooltip();

    $('#change-submit').click(function() {
        $('#ChangeModal').modal('hide');
    })

});