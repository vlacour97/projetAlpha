<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 02/12/16
 * Time: 21:00
 */

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    include "../config.php";

    switch($_GET['action']){
        case 'get_table_datas':
            $students = \app\User::get_all_students(\app\Log::get_id());
            $data = array();

            foreach($students as $student){
                /** @var $student \app\StudentDatas */

                if($student->answered){
                    if($student->answers_is_valided)
                        $status = 'fa-check';
                    else
                        $status = 'fa-clock-o';
                    $action = \general\Language::translate_gabarit('components/parts/see_survey');
                    $action = str_replace('{link}','?nav=see_survey&id='.\general\crypt::encrypt($student->ID),$action);
                }
                else{
                    $status = 'fa-times';
                    $action = \general\Language::translate_gabarit('components/parts/answer_survey');
                    $action = str_replace('{link}','?nav=answer_survey&id='.\general\crypt::encrypt($student->ID),$action);
                }


                $data[] = array(
                    sprintf('%04d',$student->ID),
                    htmlentities($student->name.' '.$student->fname),
                    htmlentities($student->name_TI),
                    "<p class='text-center'><i class='fa $status'></i></p>",
                    htmlentities($student->deadline_date->format('d MM yyyy')),
                    $action
                );
            }
            echo json_encode(["data"=>$data]);
            break;
    }
    die();
}

$html = new \general\HTML();
$gabarit = \general\Language::translate_gabarit('pages/te_studentList');

$script_vendor = array(
    'underscore/underscore-min.js',
    'backbone/backbone.js',
    'backbone.paginator/lib/backbone.paginator.min.js',
    'backgrid/lib/backgrid.js',
    'backgrid-paginator/backgrid-paginator.js',
    'datatables/media/js/jquery.dataTables.js',
    'bootstrap-select/bootstrap-select.min.js',
    'messenger/build/js/messenger.js',
    'messenger/build/js/messenger-theme-flat.js'
);
$script = "student_list_te.js";


$html->open();
$html->sidebar();
$html->navbar();
echo $gabarit;
$html->close($script_vendor,$script);