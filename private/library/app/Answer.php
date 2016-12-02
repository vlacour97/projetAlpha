<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 26/10/16
 * Time: 13:54
 */

namespace app;

use general\crypt;
use general\Date;
use general\file;
use general\Language;
use general\mail;
use general\PDOQueries;

class Answer extends \mainClass{

    static private $survey_path = "/private/parameters/surveys/";
    static $survey_marker = "s";
    static $survey_id_page = "answer";

    /**
     * Récupére les questions et les réponses d'un questionnaire (cf get_survey) et retourner cela sous forme de tableau
     * @param $id_student
     * @return array
     * @throws \Exception
     */
    static function get_answers($id_student){
        if(!PDOQueries::isset_student($id_student))
            throw new \Exception('L\'étudiant demandé n\'existe pas',2);
        $answer = PDOQueries::show_answer($id_student);
        $id_survey = $answer[0]['id_survey'];
        if(is_null($id_survey))
            return self::get_survey();
        $survey = self::get_survey($id_survey,$id_student);
        $scale = self::get_scale_survey($survey);
        $total_points = 0;
        foreach($survey->questions as $key_question=>$content_question)
        {
            $nb_point = 0;
            foreach($content_question as $key_answer=>$content_answer)
            {
                if($key_answer != "questionLbl" && $answer[$key_question]['id_answer'] == $key_answer)
                {
                    $survey->questions[$key_question]->$key_answer->choice = true;
                    $nb_point += $survey->questions[$key_question]->$key_answer->nb_point;
                }else
                    $survey->questions[$key_question]->$key_answer->choice = false;

            }
            $survey->questions[$key_question]->comments = $answer[$key_question]['comments'];
            $survey->questions[$key_question]->nb_points = $nb_point;
            if($nb_point == 0)
                $survey->questions[$key_question]->answered = false;
            else
                $survey->questions[$key_question]->answered = true;
            $total_points += $nb_point;
        }
        $survey->total_points = $total_points;
        $survey->scale = $scale;
        $survey->avg = $total_points/$scale;
        return $survey;
    }

    /**
     * Récupére le bareme de point d'un questionnaire
     * @param int|array $survey
     * @return int
     * @throws \Exception
     */
    static function get_scale_survey($survey){
        if(!is_int($survey) && !is_object($survey))
            throw new \Exception('Erreur sur le type de variable',1);
        if(is_int($survey))
            $survey = self::get_survey($survey);
        $total = 0;
        foreach($survey->questions as $key_question=>$content_question){
            $nb_point = 0;
            foreach($content_question as $key_answer=>$content_answer)
                $nb_point < $survey->questions[$key_question]->$key_answer->nb_point && $nb_point = $survey->questions[$key_question]->$key_answer->nb_point;
            $total += $nb_point;
        }
        return $total;
    }

    /**
     * Récupere les réponses, les enregistrent et declare le questionnaire comme terminé si celà est demandé
     * @param array $answer
     * @param int $id_survey
     * @param int $id_student
     * @param bool $publish
     * @return bool
     * @throws \Exception
     */
    static function set_answer($answer,$id_survey,$id_student,$publish = false){
        if(!is_array($answer) || !is_int($id_survey) || !is_int($id_student) || !is_bool($publish))
            throw new \Exception('Erreur sur le type de variable',1);
        foreach($answer as $key=>$content)
            PDOQueries::add_answer($id_student,$id_survey,$key,$content['response'],$content['comment']);
        if($publish)
        {
            if(!self::survey_is_completed($answer,$id_survey))
                throw new \Exception('Le questionnaire n\'est pas complet',2);
            return PDOQueries::update_answer_status($id_student,$publish) && mail::send_answer_email(PDOQueries::get_TI_ID_of_student($id_student)) && Notifications::complete_survey($id_student);
        }

        return true;
    }

    /**
     * Récupére les informations de tous les type de questionnaires
     * @return array
     */
    static function get_all_survey(){
        $response = array();
        $able_survey = self::get_able_survey_id();
        $iterator = 1;
        while(is_file(self::get_survey_path($iterator))){
            $datas = new \stdClass();
            $datas->name = self::get_survey_name($iterator);
            $datas->modification_date = self::get_modification_date($iterator);
            $datas->creation_date = self::get_creation_date($iterator);
            $datas->able = $iterator == $able_survey;
            $response[] = $datas;
            $iterator++;
        }
        return $response;
    }

    /**
     * Récupére les données d'un questionnaire
     * @param null|int $id
     * @param null|int $id_student
     * @return bool|mixed
     * @throws \Exception
     */
    static function get_survey($id = null,$id_student = null){
        if(is_null($id))
            $id = self::get_able_survey_id();
        if(!($json_content = file_get_contents(self::get_survey_path($id))))
            return false;

        if(is_int($id_student)){
            //Récupération des données utilisateur
            if(!($student = User::get_student($id_student)))
                throw new \Exception('Erreur lors de la récupération des données',2);
            $replace = array('{fname_student}','{name_student}');
            $by = array($student->fname,$student->name);
            $json_content = str_replace($replace,$by,$json_content);
        }

        $response = json_decode($json_content);

        return $response;
    }

    /**
     * Enregistre un questionnaire
     * @param array $questions
     * @param string $name
     * @param int|null $id
     * @return bool
     */
    static function set_survey($questions,$name,$id = null){

        if(!is_dir(ROOT.self::$survey_path))
            mkdir(ROOT.self::$survey_path);

        $survey_array = new \stdClass();

        self::add_creation_date($survey_array,$id);
        self::add_survey_name($survey_array,$name);
        self::add_questions($survey_array,$questions);

        if($id == null)
            $id = self::get_new_id();
        $path_survey = self::get_survey_path($id);

        return file_put_contents($path_survey, json_encode($survey_array));
    }

    /**
     * Recupère l'identifiant du questionnaire en cours d'utilisation
     * @return mixed
     */
    static function get_able_survey_id(){
        return Config::getCurrentSurvey();
    }

    /**
     * Mets à jour le questionnaire à utliser pour les prochains questionnaires
     * @param int $id
     * @return int
     */
    static function set_able_survey_id($id){
        return Config::setCurrentSurvey($id);
    }

    /**
     * Renvoi le lien vers un questionnaire
     * @param string $id
     * @return string|bool
     */
    static private function get_survey_path($id){
        return ROOT.self::$survey_path.$id.'.json';
    }

    /**
     * Renvoi la date de modification du questionnaire
     * @param string $id
     * @return mixed|string
     */
    static private function get_modification_date($id){
        $timestamp_date = filemtime(self::get_survey_path($id));
        $return_date = new Date(date('Y-m-d H:i:s',$timestamp_date));
        return $return_date->format(self::$form_date);
    }

    /**
     * Renvoi la date de création du questionnaire
     * @param int $id
     * @return mixed|string
     */
    static private function get_creation_date($id){
        $return_date = new Date(self::get_survey($id)->creation_date);
        return $return_date->format(self::$form_date);
    }

    /**
     * Determine si un questionnaire existe
     * @param $id
     * @return bool
     */
    static function isset_survey($id){
        if(!is_file(self::get_survey_path($id)))
            return false;
        return true;
    }

    /**
     * Ajoute la date de creation sur le questionnaire
     * @param object $survey
     * @param int|null $id
     */
    static private function add_creation_date(&$survey,$id = null){
        $date = date('Y-m-d H:i:s');

        if(is_int($id))
            $date = self::get_survey($id)->creation_date;

        $survey->creation_date = $date;
    }

    /**
     * Récupére le nom du questionnaire
     * @param int $id
     * @return mixed
     */
    static private function get_survey_name($id){
        return self::get_survey($id)->name;
    }

    /**
     * Ajoute le nom du questionnaire à un questionnaire
     * @param object $survey
     * @param string $name
     */
    static private function add_survey_name(&$survey,$name){
        $survey->name = $name;
    }

    /**
     * Ajoute les questions à un questionnaire
     * @param object $survey
     * @param array $questions
     */
    static private function add_questions(&$survey,$questions){
        $survey->questions = $questions;
    }

    /**
     * Retourne un nouvel identifiant pour un nouveau questionnaire
     * @return int
     */
    static private function get_new_id(){
        $files = scandir(ROOT.self::$survey_path);
        if(count($files) == 2)
            return 1;
        $last_file = $files[count($files) - 1];
        $last_file_name = file::file_infos(ROOT.self::$survey_path.$last_file)->name;
        return $last_file_name + 1;
    }

    /**
     * Determine si un questionnaire est completé
     * @param array $answer
     * @param int $id_survey
     * @return bool
     * @throws \Exception
     */
    static function survey_is_completed($answer,$id_survey){
        if(!is_array($answer) || !is_int($id_survey))
            throw new \Exception('Erreur sur le type de variable',1);
        $survey = self::get_survey($id_survey);
        if(count($survey->questions) != count($answer))
            return false;
        return true;
    }

    /**
     * Supprime le questionnaire d'un étudiant
     * @param int $id_student
     * @return bool
     */
    static function delete_answer($id_student){
        return PDOQueries::delete_all_answer($id_student);
    }

    /**
     * Supprime tout les questionnaires
     * @return bool
     */
    static function delete_all_answer(){
        return PDOQueries::delete_all_answer_for_all_students();
    }

    /**
     * Determine si le questionnaire d'un étudiant à été remplis ou non
     * @param int $id_student
     * @return bool
     */
    static function have_answered($id_student){
        return PDOQueries::have_answered($id_student);
    }

    /**
     * Récupére la date butoire de questionnaire d'un étudiant
     * @param $id_student
     * @return Date
     */
    static function get_deadline($id_student){
        return new Date(PDOQueries::get_deadline_date($id_student));
    }

    /**
     * Assigne une date butoire à un étudiant
     * @param int $id_student
     * @param null|string|\general\Date $date
     * @return bool
     * @throws \Exception
     */
    static function set_deadline($id_student,$date = null){
        if(!is_null($date) && !is_string($date) && !is_a($date,'\general\Date'))
            throw new \Exception('Erreur sur le type de la date',2);
        if($date == null)
            $date = self::get_static_deadline();
        if(is_a($date,'\general\Date'))
            $date = $date->format('yyyy-mm-dd');
        return PDOQueries::edit_deadline_date($id_student,$date);
    }

    /**
     * Récupére la date butoire générale
     * @return mixed
     */
    static function get_static_deadline(){
        return new Date(Config::getDeadlineDate());
    }

    /**
     * Enregistre une nouvelle date statique
     * @param null $date
     * @return int
     * @throws \Exception
     */
    static function set_static_deadline($date = null){

        //Formattage des variables
        if(!is_null($date) && !is_string($date) && !is_a($date,'\general\Date'))
            throw new \Exception('Erreur sur le type de la date',2);
        if($date == null)
            $date = self::get_static_deadline();
        if(is_string($date))
        {
            $date = new Date($date);
            $date = $date->format('yyyy-mm-dd');
        }
        if(is_a($date,'\general\Date'))
            $date = $date->format('yyyy-mm-dd');

        //Enregistrement des données
        return Config::setDeadlineDate($date);
    }

    /**
     * Determine si le questionnaire a dépassé la date butoire
     * @param int $id_student
     * @return bool
     * @throws \Exception
     */
    static function can_complete_survey($id_student){
        if(!PDOQueries::isset_student($id_student))
            throw new \Exception('L\'étudiant demandé n\'existe pas',2);
        $student = new \DateTime(self::get_deadline($id_student)->format());
        $now = new \DateTime('now');
        if($student <= $now)
            return false;
        return true;
    }

    /**
     * Valide un questionnaire
     * @param int $id_student
     * @return bool
     */
    static function validate_survey($id_student){
        $response = PDOQueries::validate_survey($id_student);
        if($response)
            mail::send_validate_answer_email(PDOQueries::get_TE_ID_of_student($id_student)) && Notifications::validate_survey($id_student);
        return $response;
    }

    /**
     * Determine si un questionnaire est validé ou non
     * @param $id_student
     * @return bool
     */
    static function is_validated($id_student){
        return PDOQueries::survey_is_validate($id_student);
    }


    /**
     * Compte le nombre de questionnaires stockés
     * @return int
     * @throws \Exception
     */
    static function count_surveys(){
        $files = scandir(ROOT.self::$survey_path);
        $response = 0;
        foreach($files as $file){
            file::isJSON($file) && $response++;
        }
        return $response;
    }

    /**
     * Génére un questionnaire en PDF
     * @param int $id_student
     * @throws \Exception
     * @throws \HTML2PDF_exception
     */
    static function generateSurveyPDF($id_student){
        $survey_datas = self::get_answers($id_student);
        $student_datas = User::get_student($id_student);
        $gabarit = Language::translate_gabarit('pdf/SurveyList');

        //Student Infos
        $link = HOST.'index.php?'.Navigation::$navigation_marker.'='.self::$survey_id_page.'&'.self::$survey_marker.'='.crypt::encrypt($id_student);
        $replace = ['{student_fname}','{student_name}','{student_group}','{student_address}','{student_email}','{student_phone}','{student_TE}','{student_TI}','{survey_link}'];
        $by = [$student_datas->fname,$student_datas->name,$student_datas->group,$student_datas->address,$student_datas->email,$student_datas->phone,$student_datas->name_TE,$student_datas->name_TI,$link];
        $gabarit = str_replace($replace,$by,$gabarit);

        //Survey
        $survey_content = '';
        /** @var $survey_datas \StdClass */
        foreach($survey_datas->questions as $key=>$content){
            $nb_point = 0;
            $survey_content .= '<tr>
            <td class="text-center"><h4 class="fw-semi-bold mt-n">'.($key+1).'-</h4></td>
            <td class="text-center"><h3>';
            $survey_content .= $content->questionLbl;
            $survey_content .=  '</h3><p class="text-center">';
            foreach($content as $question){
                if(is_a($question,'StdClass')){
                    if($question->choice)
                        $survey_content .= '&nbsp;<b>'.$question->lbl.'</b>&nbsp;&bull;';
                    else
                        $survey_content .= '&nbsp;'.$question->lbl.'&nbsp;&bull;';
                    if($nb_point < $question->nb_point)
                        $nb_point = $question->nb_point;
                }
            }
            $survey_content = substr($survey_content,0,-6);
            $survey_content .= '</p>';
            if(utf8_encode($content->comments) != "")
                $survey_content .= '<br>- '.$content->comments.' -';
            $survey_content .= '</td><td class="vMiddle text-center"><b class="mark">';
            $survey_content .= $content->nb_points;
            $survey_content .= '</b>/';
            $survey_content .= $nb_point;
            $survey_content .= '</td></tr>';
        }
        $gabarit = str_replace('{survey_datas}',$survey_content,$gabarit);
        $gabarit = str_replace('{total_mark}',round($survey_datas->avg * 20),$gabarit);

        //Génération
        include ROOT."/private/library/other/html2pdf.php";
        $html2pdf = new \HTML2PDF('P', 'A4', 'fr');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($gabarit);
        $html2pdf->Output('SurveyList.pdf');
    }

    /**
     * Génére la liste des étudiant en PDF
     * @param string $title
     * @throws \Exception
     * @throws \HTML2PDF_exception
     */
    static function generateStudentListPDF($title){
        $datas = User::get_all_students();
        $gabarit = Language::translate_gabarit('pdf/StudentList');

        //Title
        $gabarit = str_replace('{title}',$title,$gabarit);

        //StudentList
        $studentList = "";
        foreach($datas as $student){
            /** @var $student \app\StudentDatas */
            $studentList .= '<tr><td>';
            $studentList .= sprintf('%04d',$student->ID);
            $studentList .= '</td><td>';
            $studentList .= $student->fname.' '.$student->name;
            $studentList .= '</td><td>';
            $studentList .= $student->name_TE;
            $studentList .= '</td><td>';
            $studentList .= $student->name_TI;
            $studentList .= '</td><td>';
            $studentList .= $student->group;
            $studentList .= '</td><td class="text-center bold">';
            $studentList .= round(self::get_answers($student->ID)->avg * 20);
            $studentList .= '</td></tr>';
        }
        $gabarit = str_replace('{student_datas}',$studentList,$gabarit);

        //Génération
        include ROOT."/private/library/other/html2pdf.php";
        $html2pdf = new \HTML2PDF('P', 'A4', 'fr');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($gabarit);
        $html2pdf->Output('StudentList.pdf');
    }

} 