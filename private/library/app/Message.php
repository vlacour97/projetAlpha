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

/**
 * Class MessageException
 * @package app
 * @author Paul Bigourd
 */
class MessageException extends \Exception{
    private $items = array();

    public function __construct($message, $code, $items = array())
    {
        parent::__construct($message, $code);
        $this->$items;
    }

    public function getItems(){
        return $this->items;
    }
}

/**
 * Class ReturnDatas
 * @package app
 * @author Paul Bigourd
 */
class ReturnDatas{
    /**
     * @var array
     */
    public $int = array();
    /**
     * @var array
     */
    public $date = array();
    /**
     * @var array
     */
    public $bool = array();
    /**
     * @var array
     */
    public $ban = array();
}

class MessageAttachmentDatas extends  ReturnDatas{
    /**
     * @var int
     */
    public $ID;
    /**
     * @var int
     */
    public $ID_message;
    /**
     * @var string
     */
    public $link;
    /**
     * @var string
     */
    public $description;
    /**
     * @var string
     */
    public $type_file;
    /**
     * @var array
     */
    public $int = array('ID','ID_message');
}

/**
 * Class MessageDatas
 * @package app
 */
class MessageDatas extends ReturnDatas{
    /**
     * @var int
     */
    public $ID;
    /**
     * @var int
     */
    public $id_sender;
    /**
     * @var int
     */
    public $id_recipient;
    /**
     * @var string
     */
    public $object;
    /**
     * @var string
     */
    public $content;
    /**
     * @var boolean
     */
    public $viewed;
    /**
     * @var int
     */
    public $id_respond;
    /**
     * @var \general\Date
     */
    public $send_date;
    /**
     * @var array
     */
    public $message_attachement = array();
    /**
     * @var array
     */
    public $int = array('ID','id_sender','id_recipient','id_respond');
    /**
     * @var array
     */
    public $date = array('send_date');
    /**
     * @var array
     */
    public $bool = array('viewed');
    /**
     * @var array
     */
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

    /**
     * Affiche tous les messages non lus
     * @param $id_user
     * @return array
     */
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

    /**
     * Affiche les messages supprimés
     * @param $id_user
     * @return array
     */
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

    static function send_message($id_user,$id_dest,$objet,$content,$attachment_files = array(),$attachment_descriptions = array(),$reply = null)
    {
        if(is_null($reply) && !self::can_send_message($id_user,$id_dest))
            throw new \Exception('Vous n\'avez pas le droit d\'envoyer ce message !',2);
        if(!PDOQueries::publish_message($id_user,$id_dest,$objet,$content,$reply))
            throw new \Exception('Erreur lors l\'envoi de votre message',2);

        $id_message = PDOQueries::get_max_message_id();
        $exceptions = array();

        foreach ($attachment_files as $key=>$attachment_file)
        {
            try{
                self::save_message_attachment($id_message,$attachment_file,$attachment_descriptions[$key]);
            }catch (\Exception $e){
                $exceptions[] = $e;
            }
        }

        if(count($exceptions) != 0)
            throw new MessageException('Erreur lors de l\'envoi de pieces jointes',2,$exceptions);

        return true;
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
     * supprime un message
     * @param $id_message
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

    /**
     *
     * @param $id_message
     * @param $file
     * @param null $description
     * @return bool
     * @throws \Exception
     */
    static function save_message_attachment($id_message,$file,$description = null){
        $type = file::file_infos($file)->type;
        $id_message_attachments = PDOQueries::get_max_message_attachment_id()+1;
        echo 'ok';
        //ptite ligne chelou la famille un ptit coup
        echo $type;
        if($type=="image"){
            $filename = $id_message_attachments.'.jpg';
            $link = MESSAGE_CONTENT.$filename;
            echo 'ok';
            if(!PDOQueries::add_message_attachment($id_message,$link,$description,$type))
                throw new \Exception('Erreur lors de l\'enregistrement',2);
            try{
                file::upload(MESSAGE_CONTENT,$file,1024*1024*10,$filename);
            }catch(\Exception $e){
                PDOQueries::delete_message_attachments($id_message_attachments);
                throw $e;
            }
        }else{
            $type='other';

            $filename_before_zip = $id_message_attachments.'.'.file::file_infos($file)->extension;
            $filename = file::file_infos($file)->name;
            $path_file = MESSAGE_CONTENT.$filename_before_zip;
            $link = MESSAGE_CONTENT.$id_message_attachments.'.zip';

            if(!PDOQueries::add_message_attachment($id_message,$link,$description,$type))
                throw new \Exception('Erreur lors de l\'enregistrement',2);

            try{
                file::zip_file($path_file,$link,$filename);
            }catch (\Exception $e){
                PDOQueries::delete_message_attachments($id_message_attachments);
                throw $e;
            }

            file::delete($path_file);

        }

        return true;
    }

    /**
     * Supprime toutes les pièces jointes d'un message
     * @param $id_message
     * @return bool
     * @throws \Exception
     */
    static private function delete_message_attachments($id_message){
        $message_attachments= self::get_message_attachments($id_message);
        $exceptions = array();
        foreach($message_attachments as $message_attachment) {
            /** @var $message_attachment MessageAttachmentDatas */
            if(!PDOQueries::delete_message_attachments($message_attachment->ID))
                $exceptions[] = new \Exception('Erreur lors de la suppression de la pièce jointe sur la base de donnée : N°'.$message_attachment->ID,2);
            if(!file::delete($message_attachment->link))
                $exceptions[] = new \Exception('Erreur lors de la suppression de la pièce jointe : N°'.$message_attachment->ID,2);
        }
        if(count($exceptions)!=0)
            throw new MessageException('Erreur lors de la suppression',2,$exceptions);
        return true;
    }

    /**
     * Determine si un expediteur peut envoyer un message a un destinataire
     * @param $id_user
     * @param $id_dest
     * @return bool
     */

    static private function can_send_message($id_user,$id_dest){
        if(PDOQueries::isTE($id_user) && (PDOQueries::isTI($id_dest) || PDOQueries::isTE($id_dest)))
            return false;
        return true;
                //TODO faire en sorte qu'un tuteur entreprise puisse envoyer un message à un tuteur IUT dans le cas ou ils ont un liens
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