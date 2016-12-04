<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 03/12/16
 * Time: 15:12
 */

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    include "../config.php";

    switch($_GET['action']){
        case 'save_survey':
            try{
                $id_student = \general\crypt::decrypt($_GET['id']);
                $iterator = 0;
                $datas = array();
                while(isset($_POST['comment'.$iterator])){
                    is_null($_POST['radio'.$iterator]) && $_POST['radio'.$iterator] = 0;
                    $datas[] = array('response' => intval($_POST['radio'.$iterator]), 'comment' => $_POST['comment'.$iterator]);
                    $iterator++;
                }
                \app\Answer::set_answer($datas,\app\Config::getCurrentSurvey(),$id_student);
                echo json_encode(array('response'=>true,'exception'=>null,'code' => null));
            }catch (Exception $e){
                echo json_encode(array('response'=>false,'exception'=>$e->getMessage(),'code' => $e->getCode()));
            }
            break;
        case 'send_survey':
            try{
                $id_student = \general\crypt::decrypt($_GET['id']);
                $iterator = 0;
                $datas = array();
                while(isset($_POST['comment'.$iterator])){
                    is_null($_POST['radio'.$iterator]) && $_POST['radio'.$iterator] = 0;
                    $datas[] = array('response' => intval($_POST['radio'.$iterator]), 'comment' => $_POST['comment'.$iterator]);
                    $iterator++;
                }
                \app\Answer::set_answer($datas,\app\Config::getCurrentSurvey(),$id_student,true);
                echo json_encode(array('response'=>true,'exception'=>null,'code' => null));
            }catch (Exception $e){
                echo json_encode(array('response'=>false,'exception'=>$e->getMessage(),'code' => $e->getCode()));
            }
            break;
    }
    die();
}

$html = new \general\HTML();
$gabarit = \general\Language::translate_gabarit('pages/te_answer_survey');
$id = \general\crypt::decrypt($_GET['id']);

if(!\general\PDOQueries::isset_student($id) || \general\PDOQueries::have_answered($id))
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
$script = "answer_survey.js";

$survey_datas = \app\Answer::get_answers($id);
$survey_gabarit = \general\Language::translate_gabarit('components/answer_survey2');
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
                $reponses .= '<div class="radio radio-primary display-inline-block ml-n mr-n"><input type="radio" name="radio'.$key.'" id="'.$key.$key2.'" value="'.$key2.'" checked="checked"><label for="'.$key.$key2.'">'.$reponse->lbl.'</label></div>';
            else
                $reponses .= '<div class="radio radio-primary display-inline-block ml-n mr-n"><input type="radio" name="radio'.$key.'" id="'.$key.$key2.'" value="'.$key2.'"><label for="'.$key.$key2.'">'.$reponse->lbl.'</label></div>';
        }
    }

    if($question->comments != "")
    {
        $hidden = "";
        $notHidden = "hidden";
    }
    else{
        $hidden = "hidden";
        $notHidden = "";
    }

    if(isset($_GET['translate']) && $_GET['translate'] == true)
        $question->questionLbl = \general\Language::translate_text($question->questionLbl,mainClass::$lang,\app\Log::get_lang());

    $replace = array('{id-survey}','{survey-lbl}','{comment}','{responses}','{hidden}','{not-hidden}','{ID}');
    $by = array($key+1,$question->questionLbl,$question->comments,$reponses,$hidden,$notHidden,$key);
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

$replace = array('{survey_datas}','{student-id}','{student-fname}','{student-name}','{student-phone}','{student-email}','{ti-fname}','{ti-name}','{ti-phone}','{ti-email}','{te-fname}','{te-name}','{te-phone}','{te-email}','{ID_Student}','{returnPath}','{translate_button}');
$by = array($survey,\general\crypt::encrypt($student->ID),$student->fname,$student->name,$student->phone,$student->email,$ti->fname,$ti->name,$ti->phone,$ti->email,$te->fname,$te->name,$te->phone,$te->email,$_GET['id'],'?'.\app\Navigation::$navigation_marker.'=student_list',$translate_btn);
$gabarit = str_replace($replace,$by,$gabarit);

$html->open();
$html->sidebar();
$html->navbar();
echo $gabarit;
$html->close($script_vendor,$script);