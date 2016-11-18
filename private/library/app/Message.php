<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 27/10/16
 * Time: 14:35
 */

namespace app;

use general\file;
use general\PDOQueries;

class ReturnDatas{
    public $int = array();
    public $date = array();
    public $bool = array();
    public $ban = array();
}

class MessageAttachmentDatas extends  ReturnDatas{
    public $ID;
    public $ID_message;
    public $link;
    public $description;
    public $type_file;
    public $int = array('ID','ID_message');
}

class MessageDatas extends ReturnDatas{
    public $ID;
    public $id_sender;
    public $id_recipient;
    public $object;
    public $content;
    public $viewed;
    public $id_respond;
    /**
     * @var \general\Date
     */
    public $send_date;
    public $message_attachement = array();
    public $int = array('ID','id_sender','id_recipient','id_respond');
    public $date = array('send_date');
    public $bool = array('viewed');
    public $ban = array('deleted');
}

class Message extends \mainClass
{
    /**
     * Affiche tous les messages reçus
     * @param $id_user
     * @return array
     */
    static function get_all_messages($id_user)
    {
        $datas = PDOQueries::show_received_message($id_user);
        $messages = array();
        foreach($datas as $content){
            $tmp = new MessageDatas();
            self::_format_datas($content,$tmp);
            $messages[]=$tmp;

        }
        return $messages;
    }

    static function get_new_messages($id_user)
    {
        $datas = PDOQueries::show_new_messages($id_user);
        $messages = array();
        foreach($datas as $content){
            $tmp = new MessageDatas();
            self::_format_datas($content,$tmp);
            $messages[]=$tmp;

        }
        return $messages;
    }


    /**
     * Affiche un message envoyé
     * @param int $id_user
     * @return array
     */
    static function get_sended_messages($id_user)
    {
        $datas = PDOQueries::show_sended_message($id_user);
        $messages = array();
        foreach($datas as $content){
            $tmp = new MessageDatas();
            self::_format_datas($content,$tmp);
            $messages[]=$tmp;

        }
        return $messages;
    }


    static function get_deleted_messages($id_user)
    {
        $datas = PDOQueries::show_deleted_message($id_user);
        $messages = array();
        foreach($datas as $content){
            $tmp = new MessageDatas();
            self::_format_datas($content,$tmp);
            $messages[]=$tmp;

        }
        return $messages;
    }

    static function send_message()
    {
        //TODO envoi un message #prio3
    }

    static function reply_message($id_reply)
    {
        //TODO repond à un message #prio4
    }


    /**
     * Affiche un message privé
     * @param int $id_message
     * @return bool|array
     */
    static function get_message($id_message)
    {
        $datas = PDOQueries::show_message($id_message);
        $message = new MessageDatas();
        self::_format_datas($datas,$message);
        $message->message_attachement = self::get_message_attachments($id_message);
        return $message;
    }


    /**
     * Supprime un message
     * @param int $id_message
     * @return bool
     */
    static function delete_message($id_message)
    {
        return PDOQueries::delete_message($id_message);
    }

//-----------------------------------------------------------------------------------------------------------------
    /**
     * Recupére le pieces jointes
     * @param int $id_message
     * @return array
     */
    static private function get_message_attachments($id_message)
    {
        $datas = PDOQueries::show_message_attachment($id_message);
        $response = array();
        foreach($datas as $key=>$message_attachment)
        {
            $tmp = new MessageAttachmentDatas();
            self::_format_datas($message_attachment,$tmp);
            $response[] = $tmp;
        }
        return $response;
    }

    static private function save_message_attachments($id_message,$file,$description = null){
        $type = file::file_infos($file)->type;
        $id_message_attachments = PDOQueries::max
        //TODO Enregistre les piéces jointes #prio3

        //MESSAGE_CONTENT

        /**
         * Contenu à voir avec le Valentin des forêts
         */

    }

    static private function delete_message_attachments($id_message){
        //Suppression en réel et sur la bdd
    }


    static private function can_send_message($id_user,$id_dest){
        if(!is_int($id_user) && !is_int($id_dest))
            throw new \Exception('problème lors de l\'envoie du message',2);

        if($id_dest=="Admin" && $id_user!="Admin")
            throw new \Exception('vous ne pouvez pas envoyer de message a cet utilisateur',1);




        //TODO Determine si un utilisateur peut envoyer un messsage #prio1
    }

    /**
     * Formate les données pour les messages
     * @param array $datas
     * @param ReturnDatas $object
     */
    static protected function _format_datas($datas,&$object){
        foreach($datas as $key=>$content){
            if(is_string($key) && !in_array($key,$object->ban)) {
                if(in_array($key,$object->int))
                    $object->$key = intval($content);
                elseif(in_array($key,$object->date))
                    $object->$key = new \general\Date($content);
                elseif(in_array($key,$object->bool))
                    $object->$key = boolval($content);
                else
                    $object->$key = $content;
            }
        }
    }

} 