<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 28/11/16
 * Time: 21:21
 */


if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    include "../../config.php";

    switch($_GET['action']){
        case 'get_table_datas':
            $students = \app\User::get_all_students();
            $data = array();

            foreach($students as $student){
                /** @var $student \app\StudentDatas */

                $mark = round(\app\Answer::get_answers($student->ID)->avg * 20);
                if($student->answered)
                    if($student->answers_is_valided)
                        $status = 'fa-check';
                    else
                        $status = 'fa-clock-o';
                else{
                    $status = 'fa-times';
                    $mark = "";
                }


                $data[] = array(
                    sprintf('%04d',$student->ID),
                    $student->name,
                    $student->fname,
                    $student->group,
                    "<p class='text-center'><i class='fa $status'></i></p>",
                    $mark
                );
            }
            echo json_encode(["data"=>$data]);
            break;
    }
    die();
}

$html = new \general\HTML();
$gabarit = \general\Language::translate_gabarit('pages/admin_studentScore');

$script_vendor = array(
    'underscore/underscore-min.js',
    'backbone/backbone.js',
    'backbone.paginator/lib/backbone.paginator.min.js',
    'backgrid/lib/backgrid.js',
    'backgrid-paginator/backgrid-paginator.js',
    'datatables/media/js/jquery.dataTables.js',
    'bootstrap-select/bootstrap-select.min.js'
);
$script = array('survey_part1.js');


$html->open();
$html->sidebar();
$html->navbar();
echo $gabarit;
$html->close($script_vendor,$script);