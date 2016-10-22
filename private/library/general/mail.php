<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 08/10/16
 * Time: 15:55
 */

namespace general;


class mail {

    private static  $gabarit_path = "/private/views/mails/";
    private static  $img_path = "/public/img/mails/";
    private static  $activation_page = ""; //TODO Completer le chemin
    private static  $message_page= ""; //TODO Completer le chemin
    private static  $answer_page= ""; //TODO Completer le chemin
    private static  $forgotten_password_page= ""; //TODO Completer le chemin

    /**
     * Permet l'envoi de mail
     * @param string $mail  Email du destinataire
     * @param string $sujet Sujet du mail
     * @param string $message Contenu du mail
     * @return bool
     * @throws \Exception
     */
    static function send_email($mail,$sujet,$message){
        require_once $_SERVER['DOCUMENT_ROOT'].'/private/config.php';

        //Récupération des données sur l'expéditeur
        $dest_infos = link_parameters('app_config');
        $from_long = $dest_infos['name'].' <'.$dest_infos['admin_mail'].'>';
        $from_short = $dest_infos['name'].' <'.$dest_infos['admin_mail'].'>';

        // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        // En-têtes additionnels
        $headers .= 'From:' . $from_long . "\r\n";
        $headers .= 'Cc:' . $from_short . "\r\n";

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
        $texts = link_parameters('languages/'.$user_datas['language'])['general']['mail'];
        $app_name = link_parameters('app_config')['name'];

        //On génére un lien pour l'activation
        $link = "http://".$_SERVER["HTTP_HOST"].self::$activation_page."?id=".crypt::encrypt($id);

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
        $texts = link_parameters('languages/'.$user_datas['language'])['general']['mail'];
        $app_name = link_parameters('app_config')['name'];

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
        $texts = link_parameters('languages/'.$user_datas['language'])['general']['mail'];
        $app_name = link_parameters('app_config')['name'];

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
        $all_texts = link_parameters('languages/'.$recipient_datas['language'])['general'];
        $texts = $all_texts['mail'];
        $date_format = $all_texts['date']['format'];
        $app_name = link_parameters('app_config')['name'];

        //On génére un lien pour l'activation
        $link = "http://".$_SERVER["HTTP_HOST"].self::$message_page.'?id_message='.crypt::encrypt($id_message);

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

        echo $gabarit;
        //On envoi le mail et on renvoi un booleen de succés
        return true;//self::send_email($recipient_datas['email'],$subject,$gabarit);
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
        $texts = link_parameters('languages/'.$user_datas['language'])['general']['mail'];
        $app_name = link_parameters('app_config')['name'];

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
        $texts = link_parameters('languages/'.$user_datas['language'])['general']['mail'];
        $app_name = link_parameters('app_config')['name'];

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
        $texts = link_parameters('languages/'.$user_datas['language'])['general']['mail'];
        $app_name = link_parameters('app_config')['name'];

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
        $texts = link_parameters('languages/'.$user_datas['language'])['general']['mail'];
        $app_name = link_parameters('app_config')['name'];

        //On génére un lien pour l'activation
        $link = "http://".$_SERVER["HTTP_HOST"].self::$forgotten_password_page.'?id='.crypt::encrypt($id_user);

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


} 