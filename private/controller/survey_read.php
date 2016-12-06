<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 06/12/16
 * Time: 23:38
 */

$html = new \general\HTML();
$gabarit = \general\Language::translate_gabarit('pages/survey_read/public_survey_read');
$id = \general\crypt::decrypt($_GET['id']);

if(!\general\PDOQueries::isset_student($id))
    header('Location: index.php');

$script_vendor = array(
    'underscore/underscore-min.js',
    'backbone/backbone.js',
    'backbone.paginator/lib/backbone.paginator.min.js',
    'backgrid/lib/backgrid.js',
    'backgrid-paginator/backgrid-paginator.js',
    'datatables/media/js/jquery.dataTables.js',
    'bootstrap-select/bootstrap-select.min.js',
    'bootstrap-sass/vendor/assets/javascripts/bootstrap/tab.js'
);
$script = array('survey_read.js');


$survey_datas = \app\Answer::get_answers($id);
$survey_gabarit = \general\Language::translate_gabarit('components/survey_read');
$survey = "";

//echo '<pre>';
//var_dump($survey_datas);

foreach($survey_datas->questions as $key=>$question){
    $reponses = "";
    $nb_point = 0;
    foreach($question as $key2=>$reponse){
        if(is_a($reponse,'StdClass')){
            if($reponse->choice)
                $reponses .= '<div class="radio radio-primary display-inline-block ml-n mr-n"><input type="radio" name="radio2" id="'.$key.$key2.'" value="option1" disabled="disabled" checked="checked"><label for="'.$key.$key2.'">'.$reponse->lbl.'</label></div>';
            else
                $reponses .= '<div class="radio radio-primary display-inline-block ml-n mr-n"><input type="radio" name="radio2" id="'.$key.$key2.'" value="option1" disabled="disabled"><label for="'.$key.$key2.'">'.$reponse->lbl.'</label></div>';
            if($nb_point < $reponse->nb_point)
                $nb_point = $reponse->nb_point;
        }
    }
    $replace = array('{id-survey}','{survey-lbl}','{comment}','{responses}','{mark}','{total}');
    $by = array($key+1,$question->questionLbl,$question->comments,$reponses,$question->nb_points,$nb_point);
    $survey .= str_replace($replace,$by,$survey_gabarit);
}

$student = \app\User::get_student($id);
$ti = \app\User::get_user($student->ID_TI);
$te = \app\User::get_user($student->ID_TE);

$replace = array('{survey_datas}','{mark}','{student-id}','{student-fname}','{student-name}','{student-phone}','{student-email}','{ti-fname}','{ti-name}','{ti-phone}','{ti-email}','{te-fname}','{te-name}','{te-phone}','{te-email}');
$by = array($survey,round($survey_datas->avg * 20),\general\crypt::encrypt($student->ID),$student->fname,$student->name,$student->phone,$student->email,$ti->fname,$ti->name,$ti->phone,$ti->email,$te->fname,$te->name,$te->phone,$te->email);
$gabarit = str_replace($replace,$by,$gabarit);


$html->open();
echo $gabarit;
$html->close($script_vendor,$script);