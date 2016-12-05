<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 03/12/16
 * Time: 10:24
 */


if(\app\Log::get_type() == 3 && $_GET['action'] == "validate" && \general\PDOQueries::isset_student($id_student = \general\crypt::decrypt($_GET['id'])))
    if(\app\Answer::validate_survey($id_student))
        header('Location: index.php?nav=student_list');


$html = new \general\HTML();
if(\app\Log::get_type() == 3)
    $gabarit = \general\Language::translate_gabarit('pages/ti_see_survey');
else
    $gabarit = \general\Language::translate_gabarit('pages/te_see_survey');
$id = \general\crypt::decrypt($_GET['id']);

if(!\general\PDOQueries::isset_student($id) || !\general\PDOQueries::have_answered($id))
    header('Location: index.php');

$script_vendor = array(
    'underscore/underscore-min.js',
    'backbone/backbone.js',
    'backbone.paginator/lib/backbone.paginator.min.js',
    'backgrid/lib/backgrid.js',
    'backgrid-paginator/backgrid-paginator.js',
    'datatables/media/js/jquery.dataTables.js',
    'bootstrap-select/bootstrap-select.min.js',
    'messenger/build/js/messenger.js',
    'messenger/build/js/messenger-theme-flat.js',
    'bootstrap-sass/vendor/assets/javascripts/bootstrap/tab.js'
);

$survey_datas = \app\Answer::get_answers($id);
$survey_gabarit = \general\Language::translate_gabarit('components/survey_read3');
$survey = "";

(\app\Log::get_lang() == mainClass::$lang) && isset($_GET['translate']) && $_GET['translate'] = false;

foreach($survey_datas->questions as $key=>$question){
    $reponses = "";
    $nb_point = 0;
    foreach($question as $key2=>$reponse){
        if(is_a($reponse,'StdClass')){
            if(isset($_GET['translate']) && $_GET['translate'] == true)
                $reponse->lbl = \general\Language::translate_text($reponse->lbl,mainClass::$lang,\app\Log::get_lang());
            if($reponse->choice)
                $reponses .= '<div class="radio radio-primary display-inline-block ml-n mr-n"><input type="radio" name="radio2" id="'.$key.$key2.'" value="option1" disabled="disabled" checked="checked"><label for="'.$key.$key2.'">'.$reponse->lbl.'</label></div>';
            else
                $reponses .= '<div class="radio radio-primary display-inline-block ml-n mr-n"><input type="radio" name="radio2" id="'.$key.$key2.'" value="option1" disabled="disabled"><label for="'.$key.$key2.'">'.$reponse->lbl.'</label></div>';
        }
    }

    if(isset($_GET['translate']) && $_GET['translate'] == true)
        $question->questionLbl = \general\Language::translate_text($question->questionLbl,mainClass::$lang,\app\Log::get_lang());

    $replace = array('{id-survey}','{survey-lbl}','{comment}','{responses}');
    $by = array($key+1,$question->questionLbl,$question->comments,$reponses);
    $survey .= str_replace($replace,$by,$survey_gabarit);
}

$student = \app\User::get_student($id);
$ti = \app\User::get_user($student->ID_TI);
$te = \app\User::get_user($student->ID_TE);

if(\app\Log::get_lang() == mainClass::$lang)
    $translate_btn = "";

else{
    if((isset($_GET['translate']) && $_GET['translate'] == true)){
        $translate_btn = \general\Language::translate_gabarit('components/parts/translate_btn_back');
        $translate_btn = str_replace('{link}','?'.\app\Navigation::$navigation_marker.'='.$_GET[\app\Navigation::$navigation_marker].'&id='.$_GET['id'],$translate_btn);
    }else{
        $translate_btn = \general\Language::translate_gabarit('components/parts/translate_btn');
        $translate_btn = str_replace('{link}','?'.\app\Navigation::$navigation_marker.'='.$_GET[\app\Navigation::$navigation_marker].'&id='.$_GET['id'].'&translate=true',$translate_btn);
    }
}

$replace = array('{survey_datas}','{student-id}','{student-fname}','{student-name}','{student-phone}','{student-email}','{ti-fname}','{ti-name}','{ti-phone}','{ti-email}','{te-fname}','{te-name}','{te-phone}','{te-email}','{validate_link}','{translate_button}');
$by = array($survey,\general\crypt::encrypt($student->ID),$student->fname,$student->name,$student->phone,$student->email,$ti->fname,$ti->name,$ti->phone,$ti->email,$te->fname,$te->name,$te->phone,$te->email,'?nav=see_survey&action=validate&id='.\general\crypt::encrypt($student->ID),$translate_btn);
$gabarit = str_replace($replace,$by,$gabarit);

$html->open();
$html->sidebar();
$html->navbar();
echo $gabarit;
$html->close($script_vendor,$script);