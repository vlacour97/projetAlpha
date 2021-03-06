<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 08/10/16
 * Time: 15:55
 */

namespace general;


use app\Config;
use app\Log;
use app\Navigation;
use app\Stats;

class mail extends \mainClass{

    private static  $gabarit_path = "/private/views/mails/";
    private static  $img_path = "/public/img/mails/";
    private static  $activation_page = "?nav=active_user";
    private static  $message_page= "?nav=message";
    private static  $answer_page= "?nav=student_list";
    private static  $forgotten_password_page= "forbiden_password";
    private static  $get_id = "id";
    private static  $get_id_message = "id_message";

    /**
     * Permet l'envoi de mail
     * @param string $mail  Email du destinataire
     * @param string $sujet Sujet du mail
     * @param string $message Contenu du mail
     * @return bool
     * @throws \Exception
     */
    static function send_email($mail,$sujet,$message){

        //Récupération des données sur l'expéditeur
        $dest_infos = link_parameters('app_config');
        $from_long = $dest_infos['name'].' <'.$dest_infos['admin_mail'].'>';
        $from_short = $dest_infos['name'].' <'.$dest_infos['admin_mail'].'>';

        // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        // En-têtes additionnels
        $headers .= 'From:' . $from_long . "\r\n";
        $headers .= 'Cc:' . $from_short . "\r\n"; //TODO À désactiver à la livraison

        // Envoi du mail HTML et test d'envoi
        if(!mail($mail,$sujet,$message,$headers))
            throw new \Exception('Erreur lors de l\'envoi du mail');
        return true;
    }

    /**
     * Récupére le gabarit d'un email
     * @param string $gabarit_name
     * @return string
     */
    private static function get_gabarit($gabarit_name){
        //Initialisation des variables
        $file_path =  $_SERVER['DOCUMENT_ROOT'].self::$gabarit_path.$gabarit_name.".html";

        //Si le cabarit existe on revois son contenu sinon rien
        if(file_exists($file_path))
            return file_get_contents($file_path);
        return "";
    }

    /**
     * Envoi un mail de confirmation
     * @param int $id_user
     * @return bool
     * @throws /Exception
     */
    static function send_activation_email($id_user){
        //On récupére les données de l'utilisateur
        if(($user_datas = PDOQueries::show_user($id_user)) === FALSE)
            throw new \Exception('Erreur lors de la récupération des informations utilisateur',2);

        //On récupére les contenus à utiliser
        $user_datas['language'] == "" && $user_datas['language'] = \mainClass::$lang;
        $texts = Language::get_mail_text($user_datas['language']);
        $app_name = Config::getName();

        //On génére un lien pour l'activation
        $link = "http://".$_SERVER["HTTP_HOST"].self::$activation_page."&".self::$get_id."=".crypt::encrypt($id_user);

        //On récupére le gabarit du mail
        $gabarit = self::get_gabarit('activateAccount');

        //On organise les données à inserer
        $img_path = "http://".$_SERVER["HTTP_HOST"].self::$img_path;
        $general_text = $texts['general'];
        $current_text = $texts['activation'];

        //Replace les marqueurs du gabarit avec des données valables
        $what_changes = array(
            '{img_path}' => $img_path,
            '{part1_title}' => $general_text['part1']['title'],
            '{part1_content}' => $general_text['part1']['content'],
            '{part2_title}' => $general_text['part2']['title'],
            '{part2_content}' => $general_text['part2']['content'],
            '{part3_title}' => $general_text['part3']['title'],
            '{part3_content}' => $general_text['part3']['content'],
            '{app_name}' => $app_name,
            '{button_text}' => $current_text['button_text'],
            '{content}' => $current_text['content'],
            '{title}' => $current_text['title'],
            '{button_link}' => $link
        );
        foreach($what_changes as $key=>$content)
            $gabarit = str_replace($key,$content,$gabarit);

        //On définie le sujet du mail
        $subject = $current_text['subject'];

        //On envoi le mail et on renvoi un booleen de succés
        return self::send_email($user_datas['email'],$subject,$gabarit);
    }

    /**
     * Envoi un email de confirmation d'activation de compte
     * @param int $id_user
     * @return bool
     * @throws \Exception
     */
    static function send_confirmation_email($id_user){
        //On récupére les données de l'utilisateur
        if(($user_datas = PDOQueries::show_user($id_user)) === FALSE)
            throw new \Exception('Erreur lors de la récupération des informations utilisateur',2);

        //On récupére les contenus à utiliser
        $user_datas['language'] == "" && $user_datas['language'] = \mainClass::$lang;
        $texts = Language::get_mail_text($user_datas['language']);
        $app_name = Config::getName();

        //On génére un lien pour l'activation
        $link = "http://".$_SERVER["HTTP_HOST"];

        //On récupére le gabarit du mail
        $gabarit = self::get_gabarit('confirmAccount');

        //On organise les données à inserer
        $img_path = "http://".$_SERVER["HTTP_HOST"].self::$img_path;
        $general_text = $texts['general'];
        $current_text = $texts['confirmation'];

        //Replace les marqueurs du gabarit avec des données valables
        $what_changes = array(
            '{img_path}' => $img_path,
            '{part1_title}' => $general_text['part1']['title'],
            '{part1_content}' => $general_text['part1']['content'],
            '{part2_title}' => $general_text['part2']['title'],
            '{part2_content}' => $general_text['part2']['content'],
            '{part3_title}' => $general_text['part3']['title'],
            '{part3_content}' => $general_text['part3']['content'],
            '{app_name}' => $app_name,
            '{button_text}' => $current_text['button_text'],
            '{content}' => $current_text['content'],
            '{title}' => $current_text['title'],
            '{button_link}' => $link
        );
        foreach($what_changes as $key=>$content)
            $gabarit = str_replace($key,$content,$gabarit);

        //On définie le sujet du mail
        $subject = $current_text['subject'];
        //On envoi le mail et on renvoi un booleen de succés
        return self::send_email($user_datas['email'],$subject,$gabarit);
    }

    /**
     * Envoi un message d'information concernant la suppression d'un utilisateur
     * @param $id_user
     * @return bool
     * @throws \Exception
     */
    static function send_deletion_email($id_user){
        //On récupére les données de l'utilisateur
        if(($user_datas = PDOQueries::show_user($id_user)) === FALSE)
            throw new \Exception('Erreur lors de la récupération des informations utilisateur',2);

        //On récupére les contenus à utiliser
        $user_datas['language'] == "" && $user_datas['language'] = \mainClass::$lang;
        $texts = Language::get_mail_text($user_datas['language']);
        $app_name = Config::getName();

        //On récupére le gabarit du mail
        $gabarit = self::get_gabarit('deleteAccount');

        //On organise les données à inserer
        $img_path = "http://".$_SERVER["HTTP_HOST"].self::$img_path;
        $general_text = $texts['general'];
        $current_text = $texts['delete'];

        //Replace les marqueurs du gabarit avec des données valables
        $what_changes = array(
            '{img_path}' => $img_path,
            '{part1_title}' => $general_text['part1']['title'],
            '{part1_content}' => $general_text['part1']['content'],
            '{part2_title}' => $general_text['part2']['title'],
            '{part2_content}' => $general_text['part2']['content'],
            '{part3_title}' => $general_text['part3']['title'],
            '{part3_content}' => $general_text['part3']['content'],
            '{app_name}' => $app_name,
            '{content}' => $current_text['content'],
            '{title}' => $current_text['title'],
        );
        foreach($what_changes as $key=>$content)
            $gabarit = str_replace($key,$content,$gabarit);

        //On définie le sujet du mail
        $subject = $current_text['subject'];

        //On envoi le mail et on renvoi un booleen de succés
        return self::send_email($user_datas['email'],$subject,$gabarit);
    }

    /**
     * Envoi un message de notification de message
     * @param int $id_message
     * @return bool
     * @throws \Exception
     */
    static function send_receive_message_email($id_message){

        //On récupére les données du message
        if(($msg_datas = PDOQueries::show_message($id_message)) === FALSE)
            throw new \Exception('Erreur lors de la récupération des informations du message',2);

        //Si le message n'existe pas on sort
        if(is_null($msg_datas))
            throw new \Exception('Erreur lors de l\'envoi de l\'email : Le message en question n\existe pas',1);

        //On récupére les données de l'expéditeur
        if(($sender_datas = PDOQueries::show_user(intval($msg_datas['id_sender']))) === FALSE)
            throw new \Exception('Erreur lors de la récupération des informations utilisateur',2);

        //On récupére les données du destinataire
        if(($recipient_datas = PDOQueries::show_user(intval($msg_datas['id_recipient']))) === FALSE)
            throw new \Exception('Erreur lors de la récupération des informations utilisateur',2);

        //On récupére les contenus à utiliser
        $recipient_datas['language'] == "" && $recipient_datas['language'] = \mainClass::$lang;
        $texts = Language::get_mail_text($recipient_datas['language']);
        $date_format = Language::get_date_text()['format'];
        $app_name = Config::getName();

        //On génére un lien pour l'activation
        $link = "http://".$_SERVER["HTTP_HOST"].self::$message_page."?".self::$get_id_message."=".crypt::encrypt($id_message);

        //On récupére le gabarit du mail
        $gabarit = self::get_gabarit('msg');

        //On organise les données à inserer
        $img_path = "http://".$_SERVER["HTTP_HOST"].self::$img_path;
        $general_text = $texts['general'];
        $current_text = $texts['message'];
        $date_action = new Date($msg_datas['send_date'],$recipient_datas['language']);

        //Replace les marqueurs du gabarit avec des données valables
        $what_changes = array(
            '{img_path}' => $img_path,
            '{part1_title}' => $general_text['part1']['title'],
            '{part1_content}' => $general_text['part1']['content'],
            '{part2_title}' => $general_text['part2']['title'],
            '{part2_content}' => $general_text['part2']['content'],
            '{part3_title}' => $general_text['part3']['title'],
            '{part3_content}' => $general_text['part3']['content'],
            '{app_name}' => $app_name,
            '{button_text}' => $current_text['button_text'],
            '{button_link}' => $link,
            '{title}' => $current_text['title'],
            '{message_content}' => Text::cutString($msg_datas['content'],0,150),
            '{user_name}' => $sender_datas['fname'].' '.$sender_datas['name'],
            '{action_time}' => $date_action->format($date_format['the'].' '.$date_format['long_form_date'].' '.$date_format['at'].' '.$date_format['short_time_form'])
        );
        foreach($what_changes as $key=>$content)
            $gabarit = str_replace($key,$content,$gabarit);

        //On définie le sujet du mail
        $subject = str_replace('{user_name}',$what_changes['{user_name}'],$current_text['subject']);

        //On envoi le mail et on renvoi un booleen de succés
        return self::send_email($recipient_datas['email'],$subject,$gabarit);
    }

    /**
     * Envoi un message d'information concernant des questionnaires en attentes
     * @param int $id_user
     * @return bool
     * @throws \Exception
     */
    static function send_answer_email($id_user){
        //On récupére les données de l'utilisateur
        if(($user_datas = PDOQueries::show_user($id_user)) === FALSE)
            throw new \Exception('Erreur lors de la récupération des informations utilisateur',2);

        //On récupére les contenus à utiliser
        $user_datas['language'] == "" && $user_datas['language'] = \mainClass::$lang;
        $texts = Language::get_mail_text($user_datas['language']);
        $app_name = Config::getName();

        //On génére un lien pour l'activation
        $link = "http://".$_SERVER["HTTP_HOST"].self::$answer_page;

        //On récupére le gabarit du mail
        $gabarit = self::get_gabarit('question');

        //On organise les données à inserer
        $img_path = "http://".$_SERVER["HTTP_HOST"].self::$img_path;
        $general_text = $texts['general'];
        $current_text = $texts['question'];

        //Replace les marqueurs du gabarit avec des données valables
        $what_changes = array(
            '{img_path}' => $img_path,
            '{part1_title}' => $general_text['part1']['title'],
            '{part1_content}' => $general_text['part1']['content'],
            '{part2_title}' => $general_text['part2']['title'],
            '{part2_content}' => $general_text['part2']['content'],
            '{part3_title}' => $general_text['part3']['title'],
            '{part3_content}' => $general_text['part3']['content'],
            '{app_name}' => $app_name,
            '{button_text}' => $current_text['button_text'],
            '{content}' => $current_text['content'],
            '{title}' => $current_text['title'],
            '{button_link}' => $link
        );
        foreach($what_changes as $key=>$content)
            $gabarit = str_replace($key,$content,$gabarit);

        //On définie le sujet du mail
        $subject = $current_text['subject'];

        //On envoi le mail et on renvoi un booleen de succés
        return self::send_email($user_datas['email'],$subject,$gabarit);
    }

    /**
     * Permet l'envoi d'un email de notification de changement de tous les questionnaires
     * @param null|array $teList
     * @return bool
     * @throws \Exception
     */
    static function send_update_survey_notification($teList = null){

        is_null($teList) && $teList = PDOQueries::show_te_users();
        $response = true;

        foreach($teList as $user_datas){

            //On récupére les contenus à utiliser
            $user_datas['language'] == "" && $user_datas['language'] = \mainClass::$lang;
            $texts = Language::get_mail_text($user_datas['language']);
            $app_name = Config::getName();

            //On génére un lien pour l'activation
            $link = "http://".$_SERVER["HTTP_HOST"].self::$answer_page;

            //On récupére le gabarit du mail
            $gabarit = self::get_gabarit('update_survey_notification');

            //On organise les données à inserer
            $img_path = "http://".$_SERVER["HTTP_HOST"].self::$img_path;
            $general_text = $texts['general'];
            $current_text = $texts['update_survey_notification'];

            //Replace les marqueurs du gabarit avec des données valables
            $what_changes = array(
                '{img_path}' => $img_path,
                '{part1_title}' => $general_text['part1']['title'],
                '{part1_content}' => $general_text['part1']['content'],
                '{part2_title}' => $general_text['part2']['title'],
                '{part2_content}' => $general_text['part2']['content'],
                '{part3_title}' => $general_text['part3']['title'],
                '{part3_content}' => $general_text['part3']['content'],
                '{app_name}' => $app_name,
                '{button_text}' => $current_text['button_text'],
                '{content}' => $current_text['content'],
                '{title}' => $current_text['title'],
                '{button_link}' => $link
            );
            foreach($what_changes as $key=>$content)
                $gabarit = str_replace($key,$content,$gabarit);

            //On définie le sujet du mail
            $subject = $current_text['subject'];

            //On envoi le mail et on renvoi un booleen de succés
            $response = self::send_email($user_datas['email'],$subject,$gabarit) && $response;
        }
        return $response;
    }

    /**
     * Envoi un message d'information quant à la remise en service d'un compte utilisateur
     * @param $id_user
     * @return bool
     * @throws \Exception
     */
    static function send_reactivation_email($id_user){
        //On récupére les données de l'utilisateur
        if(($user_datas = PDOQueries::show_user($id_user)) === FALSE)
            throw new \Exception('Erreur lors de la récupération des informations utilisateur',2);

        //On récupére les contenus à utiliser
        $user_datas['language'] == "" && $user_datas['language'] = \mainClass::$lang;
        $texts = Language::get_mail_text($user_datas['language']);
        $app_name = Config::getName();

        //On génére un lien pour l'activation
        $link = "http://".$_SERVER["HTTP_HOST"];

        //On récupére le gabarit du mail
        $gabarit = self::get_gabarit('reactivateAccount');

        //On organise les données à inserer
        $img_path = "http://".$_SERVER["HTTP_HOST"].self::$img_path;
        $general_text = $texts['general'];
        $current_text = $texts['reactivation'];

        //Replace les marqueurs du gabarit avec des données valables
        $what_changes = array(
            '{img_path}' => $img_path,
            '{part1_title}' => $general_text['part1']['title'],
            '{part1_content}' => $general_text['part1']['content'],
            '{part2_title}' => $general_text['part2']['title'],
            '{part2_content}' => $general_text['part2']['content'],
            '{part3_title}' => $general_text['part3']['title'],
            '{part3_content}' => $general_text['part3']['content'],
            '{app_name}' => $app_name,
            '{button_text}' => $current_text['button_text'],
            '{content}' => $current_text['content'],
            '{title}' => $current_text['title'],
            '{button_link}' => $link,
            '{app_html_link}' => '<a href="'.$link.'">'.$app_name.'</a>'
        );
        foreach($what_changes as $key=>$content)
            $gabarit = str_replace($key,$content,$gabarit);

        //On définie le sujet du mail
        $subject = $current_text['subject'];

        //On envoi le mail et on renvoi un booleen de succés
        return self::send_email($user_datas['email'],$subject,$gabarit);
    }

    /**
     * Envoi un message d'information concernant la validation de questionnaire par un tuteur IUT
     * @param int $id_user
     * @return bool
     * @throws \Exception
     */
    static function send_validate_answer_email($id_user){
        //On récupére les données de l'utilisateur
        if(($user_datas = PDOQueries::show_user($id_user)) === FALSE)
            throw new \Exception('Erreur lors de la récupération des informations utilisateur',2);

        //On récupére les contenus à utiliser
        $user_datas['language'] == "" && $user_datas['language'] = \mainClass::$lang;
        $texts = Language::get_mail_text($user_datas['language']);
        $app_name = Config::getName();

        //On génére un lien pour l'activation
        $link = "http://".$_SERVER["HTTP_HOST"];

        //On récupére le gabarit du mail
        $gabarit = self::get_gabarit('repQuestion');

        //On organise les données à inserer
        $img_path = "http://".$_SERVER["HTTP_HOST"].self::$img_path;
        $general_text = $texts['general'];
        $current_text = $texts['reponse_question'];

        //Replace les marqueurs du gabarit avec des données valables
        $what_changes = array(
            '{img_path}' => $img_path,
            '{part1_title}' => $general_text['part1']['title'],
            '{part1_content}' => $general_text['part1']['content'],
            '{part2_title}' => $general_text['part2']['title'],
            '{part2_content}' => $general_text['part2']['content'],
            '{part3_title}' => $general_text['part3']['title'],
            '{part3_content}' => $general_text['part3']['content'],
            '{app_name}' => $app_name,
            '{content}' => $current_text['content'],
            '{title}' => $current_text['title']
        );
        foreach($what_changes as $key=>$content)
            $gabarit = str_replace($key,$content,$gabarit);

        //On définie le sujet du mail
        $subject = $current_text['subject'];

        //On envoi le mail et on renvoi un booleen de succés
        return self::send_email($user_datas['email'],$subject,$gabarit);
    }

    /**
     * Envoi un message permettant la modification d'un mot de passe lors de la perte de celui-ci
     * @param int $id_user
     * @return bool
     * @throws \Exception
     */
    static function send_forgotten_password_email($id_user){
        //On récupére les données de l'utilisateur
        if(($user_datas = PDOQueries::show_user($id_user)) === FALSE)
            throw new \Exception('Erreur lors de la récupération des informations utilisateur',2);

        //On récupére les contenus à utiliser
        $user_datas['language'] == "" && $user_datas['language'] = \mainClass::$lang;
        $texts = Language::get_mail_text($user_datas['language']);
        $app_name = Config::getName();

        //On génére un lien pour l'activation
        $link = "http://".$_SERVER["HTTP_HOST"].'?'.Navigation::$navigation_marker.'='.self::$forgotten_password_page."&".self::$get_id."=".crypt::encrypt($id_user);

        //On récupére le gabarit du mail
        $gabarit = self::get_gabarit('forgottenPassword');

        //On organise les données à inserer
        $img_path = "http://".$_SERVER["HTTP_HOST"].self::$img_path;
        $general_text = $texts['general'];
        $current_text = $texts['forgotten_password'];

        //Replace les marqueurs du gabarit avec des données valables
        $what_changes = array(
            '{img_path}' => $img_path,
            '{part1_title}' => $general_text['part1']['title'],
            '{part1_content}' => $general_text['part1']['content'],
            '{part2_title}' => $general_text['part2']['title'],
            '{part2_content}' => $general_text['part2']['content'],
            '{part3_title}' => $general_text['part3']['title'],
            '{part3_content}' => $general_text['part3']['content'],
            '{app_name}' => $app_name,
            '{button_text}' => $current_text['button_text'],
            '{content}' => $current_text['content'],
            '{title}' => $current_text['title'],
            '{button_link}' => $link
        );
        foreach($what_changes as $key=>$content)
            $gabarit = str_replace($key,$content,$gabarit);

        //On définie le sujet du mail
        $subject = $current_text['subject'];

        //On envoi le mail et on renvoi un booleen de succés
        return self::send_email($user_datas['email'],$subject,$gabarit);
    }

    static function feedback_bug($subject,$content,$author){
        $contentMail  = '<b>Ticket #'.time().'</b><br>';
        $contentMail .= '<b>Contenu du message :</b> <br>'.nl2br($content).'<br>';
        $contentMail .= '<b>Auteur :</b> '.$author.'<br>';
        $contentMail .= '<b>Page de soumission :</b> '.$_SERVER['HTTP_REFERER'].'<br>';
        $contentMail .= '<b>Platforme :</b> '.link_parameters('general/platforms')[Log::get_platform()].'<br>';
        $contentMail .= '<b>OS :</b> '.Log::get_os_name(Log::get_OS()).'<br>';
        $contentMail .= '<b>Navigateur :</b> '.Log::get_browser_name(Log::get_browser()).'<br>';
        $contentMail .= '<b>Langue :</b> '.link_parameters('languages/dictionnary')[Log::get_lang()];
        $subject = 'Ticket #' . time() . ' - ' . $subject;
        $mail = Config::getAdminMail();
        return self::send_email($mail,$subject,$contentMail);
    }

} 