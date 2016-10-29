<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 26/10/16
 * Time: 13:54
 */

namespace app;

use general\Date;
use general\file;
use general\mail;
use general\PDOQueries;

class Answer extends \mainClass{

    static private $survey_path = "/private/parameters/surveys/";

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
        $survey = self::get_survey($id_survey);
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
            var_dump(PDOQueries::add_answer($id_student,$id_survey,$key,$content['response'],$content['comment']));
        if($publish)
        {
            if(!self::survey_is_completed($answer,$id_survey))
                throw new \Exception('Le questionnaire n\'est pas complet',2);
            PDOQueries::update_answer_status($id_student,$publish);
            mail::send_answer_email(PDOQueries::get_TI_ID_of_student($id_student));
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
     * @param int $id
     * @return bool|mixed
     */
    static function get_survey($id = null){
        if(is_null($id))
            $id = self::get_able_survey_id();
        if(!($json_content = file_get_contents(self::get_survey_path($id))))
            return false;
        return json_decode($json_content);
    }

    /**
     * Enregistre un questionnaire
     * @param array $questions
     * @param string $name
     * @param int|null $id
     * @return bool
     */
    static function set_survey($questions,$name,$id = null){

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
     * @param $survey
     * @return mixed|string
     */
    static private function get_creation_date($id){
        $return_date = new Date(self::get_survey($id)->creation_date);
        return $return_date->format(self::$form_date);
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
     * @param $survey
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
            mail::send_validate_answer_email(PDOQueries::get_TE_ID_of_student($id_student));
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

} 