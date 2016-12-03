<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 27/10/16
 * Time: 15:00
 */

namespace app;


use general\crypt;
use general\Date;
use general\Language;
use general\PDOQueries;

/**
 * Class NotificationsForm
 * @package app
 * @author Valentin Lacour
 */
class NotificationsForm{
    /**
     * @var string
     */
    public $text;
    /**
     * @var string
     */
    public $link;
    /**
     * @var string
     */
    public $icon;
    /**
     * @var \general\Date
     */
    public $date;
}

/**
 * Class Notifications
 * @package app
 * @author Valentin Lacour
 */
class Notifications extends \mainClass{

    /**
     * Récupére les notifications du client
     * @return array
     * @throws \Exception
     */
    static function get_notifications(){
        $texts = Language::get_notification_texts();
        $notifications = PDOQueries::show_notification(Log::get_id());
        $response = array();

        foreach($notifications as $content){
            $response[] = self::formate_notification($content['content'],$content['link'],$texts,$content['requested_date']);
        }

        return $response;
    }

    /**
     * Compte le nombre de notifications
     * @return int
     * @throws \Exception
     */
    static function countNotifications(){
        return PDOQueries::count_notifications(Log::get_id());
    }

    /**
     * Formate une notification
     * @param string $content
     * @param string $link
     * @param array $texts
     * @return NotificationsForm
     */
    static private function formate_notification($content,$link,$texts,$requested_date){
        $response = new NotificationsForm();
        //Récupération des marqueurs
        preg_match_all(Language::$regex_marker, $content, $markers);
        //Génération des textes
        $text = $texts[$markers[1][0]]['value'];
        if(isset($markers[1][1]))
        {
            $datas = explode('/',$markers[1][1]);
            if($datas[0] == 'id_user' || $datas[0] == 'id_publisher')
            {
                $markers[0][1] = '{'.str_replace('id','name',$datas[0]).'}';
                $user_datas = PDOQueries::show_user(intval($datas[1]));
                $text = str_replace($markers[0][1],$user_datas['fname'].' '.$user_datas['name'],$text);
            }
        }
        //Retour des informations
        $response->text = $text;
        $response->link = $link;
        $response->date = new Date($requested_date);
        $response->icon = $texts[$markers[1][0]]['icon'];
        return $response;
    }

    /**
     * Envoi une notifications à tout les utilisateur lors de la publication d'un post
     * @param int $id_post
     * @return bool
     * @throws \Exception
     */
    static function add_post($id_post){
        if(!is_int($id_post))
            throw new \Exception('Erreur : Format de données invalide',2);
        if(($users = PDOQueries::show_all_users()) == false || !(($id_user = PDOQueries::get_publisher_id($id_post)) > 0))
            throw new \Exception('Erreur : La récupération des données a échoué',2);
        $marker = '{add_post}{id_user/'.$id_user.'}';
        $link = 'index.php?'.Navigation::$navigation_marker.'='.Timeline::$post_id_page.'#'.$id_post;
        foreach ($users as $content)
            PDOQueries::add_notification(intval($content['ID']),$marker,$link);
        return true;

    }

    /**
     * Envoi une notification lorsque l'on commente un post
     * @param int $id_comment
     * @return bool
     * @throws \Exception
     */
    static function comment_post($id_comment){
        if(!(($id_user = PDOQueries::get_post_publisher_id_by_comment($id_comment)) > 0) || !(($id_post = PDOQueries::get_post_id_by_comment($id_comment)) > 0) || !(($id_publisher = PDOQueries::get_publisher_id($id_post)) > 0))
            throw new \Exception('Erreur : La récupération des données a échoué',2);
        $marker = '{comment_post}{id_publisher/'.$id_user.'}';
        $link = 'index.php?'.Navigation::$navigation_marker.'='.Timeline::$post_id_page.'#'.$id_post.$id_comment;
        return PDOQueries::add_notification($id_publisher,$marker,$link);
    }

    /**
     * Envoi une notification lors du like d'un post
     * @param int $id_post
     * @param int $id_liker
     * @return bool
     * @throws \Exception
     */
    static function like_post($id_post,$id_liker){
        if(!(($id_user = PDOQueries::get_publisher_id($id_post)) > 0))
            throw new \Exception('Erreur : La récupération des données a échoué',2);
        $marker = '{like_post}{id_user/'.$id_liker.'}';
        $link = 'index.php?'.Navigation::$navigation_marker.'='.Timeline::$post_id_page.'#'.$id_post;
        return PDOQueries::add_notification($id_user,$marker,$link);
    }

    /**
     * Envoi une notification d'attente de questionnaire
     * @param int $id_student
     * @return bool
     * @throws \Exception
     */
    static function wait_survey($id_student){
        if(!($id_user = PDOQueries::get_TE_ID_of_student($id_student)) > 0)
            throw new \Exception('Erreur : La récupération des données a échoué',2);
        $marker = '{wait_survey}';
        $link = 'index.php?'.Navigation::$navigation_marker.'='.Answer::$survey_id_page.'&'.Answer::$survey_marker.'='.$id_student;
        return PDOQueries::add_notification($id_user,$marker,$link);
    }

    /**
     * Envoi une notification lorsqu'un questionnaire est complété
     * @param int $id_student
     * @return bool
     * @throws \Exception
     */
    static function complete_survey($id_student){
        if(!($id_user = PDOQueries::get_TI_ID_of_student($id_student)) > 0)
            throw new \Exception('Erreur : La récupération des données a échoué',2);
        $marker = '{complete_survey}';
        $link = 'index.php?'.Navigation::$navigation_marker.'='.Answer::$survey_id_page.'&'.Answer::$survey_marker.'='.crypt::encrypt($id_student);
        return PDOQueries::add_notification($id_user,$marker,$link);
    }

    /**
     * Envoi une notification lorsqu'un questionnaire est validé
     * @param int $id_student
     * @return bool
     * @throws \Exception
     */
    static function validate_survey($id_student){
        if(!($id_user = PDOQueries::get_TE_ID_of_student($id_student)) > 0)
            throw new \Exception('Erreur : La récupération des données a échoué',2);
        $marker = '{validate_survey}';
        $link = 'index.php?'.Navigation::$navigation_marker.'='.Answer::$survey_id_page.'&'.Answer::$survey_marker.'='.$id_student;
        return PDOQueries::add_notification($id_user,$marker,$link);
    }

    /**
     * Envoi une notification lorsqu'un utilisateur à l'autorisation de publier
     * @param $id_user
     * @return bool
     */
    static function autorised_publication($id_user){
        $marker = '{autorised_publication}';
        $link = 'index.php?'.Navigation::$navigation_marker.'='.Timeline::$post_id_page;
        return PDOQueries::add_notification($id_user,$marker,$link);
    }

} 