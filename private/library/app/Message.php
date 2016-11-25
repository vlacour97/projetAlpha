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

    /**
     * @var array
     */
    public $items;

    /**
     * @param null $message
     * @param int $code
     * @param array $items
     * @param \Exception $previous
     */
    public function __construct($message = null, $code = 0, $items = array(),\Exception $previous = null){
        parent::__construct($message,$code,$previous);
        $this->items = $items;
    }

    /**
     * @return array
     */
    public function getItems(){
        return $this->items;
    }
}

/**
 * Class MessageAttachmentDatas
 * @package app
 * @author Paul Bigourd
 */
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
     * @var string
     */
    public $recipient_name;
    /**
     * @var string
     */
    public $sender_name;
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
    public $dates = array('send_date');
    /**
     * @var array
     */
    public $bool = array('viewed');
    /**
     * @var array
     */
    public $useless_attr = array('deleted');
}

/**
 * Class Message
 * @package app
 * @author Paul Bigourd
 */
class Message extends \mainClass
{
    /**
     * Affiche tous les messages reçus
     * @param int $id_user
     * @return array
     */
    static function get_all_messages($id_user)
    {
        $datas = PDOQueries::show_received_message($id_user);
        $messages = array();
        foreach($datas as $content){
            $tmp = new MessageDatas();
            ReturnDatas::format_datas($content,$tmp);
            $tmp->message_attachement = self::get_message_attachments($tmp->ID);
            $messages[]=$tmp;
        }
        return $messages;
    }

    /**
     * Affiche tous les messages non lus
     * @param int $id_user
     * @return array
     */
    static function get_new_messages($id_user)
    {
        $datas = PDOQueries::show_new_messages($id_user);
        $messages = array();
        foreach($datas as $content){
            $tmp = new MessageDatas();
            ReturnDatas::format_datas($content,$tmp);
            $tmp->message_attachement = self::get_message_attachments($tmp->ID);
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
            ReturnDatas::format_datas($content,$tmp);
            $tmp->message_attachement = self::get_message_attachments($tmp->ID);
            $messages[]=$tmp;

        }
        return $messages;
    }

    /**
     * Affiche les messages supprimés
     * @param int $id_user
     * @return array
     */
    static function get_deleted_messages($id_user)
    {
        $datas = PDOQueries::show_deleted_message($id_user);
        $messages = array();
        foreach($datas as $content){
            $tmp = new MessageDatas();
            ReturnDatas::format_datas($content,$tmp);
            $tmp->message_attachement = self::get_message_attachments($tmp->ID);
            $messages[]=$tmp;

        }
        return $messages;
    }

    /**
     * @param int $id_user
     * @param int $id_dest
     * @param string $objet
     * @param string $content
     * @param array $attachment_files
     * @param array $attachment_descriptions
     * @param null|int $reply
     * @return bool
     * @throws MessageException
     * @throws \Exception
     */
    static function send_message($id_user,$id_dest,$objet,$content,$attachment_files = array(),$attachment_descriptions = array(),$reply = null)
    {
        if(!is_null($reply) && is_null(PDOQueries::show_message($reply)))
            throw new \Exception('Impossible de repondre à ce message',2);

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
     * @return array
     */
    static function get_message($id_message)
    {
        $datas = PDOQueries::show_message($id_message);
        $message = new MessageDatas();
        ReturnDatas::format_datas($datas,$message);
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

    /**
     * Compte le nombre de nouveau messages
     * @param int $id_user
     * @return int
     */
    static function count_message($id_user){
        return count(PDOQueries::show_received_message($id_user));
    }

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
            ReturnDatas::format_datas($message_attachment,$tmp);
            $response[] = $tmp;
        }
        return $response;
    }

    /**
     * Permet l'enregistrement des piéces jointes
     * @param int $id_message
     * @param array $file
     * @param null|string $description
     * @return bool
     * @throws \Exception
     */
    static  function save_message_attachment($id_message,$file,$description = null){
        $type = file::file_infos($file)->type;
        $id_message_attachments = PDOQueries::get_maxID_message_attachment()+1;
        $repo_path = ROOT.MESSAGE_ATTACHMENT_PATH;

        if($type=="image"){
            $filename = $id_message_attachments.'.jpg';
            $link = MESSAGE_ATTACHMENT_PATH.$filename;

            if(!PDOQueries::add_message_attachment($id_message,$link,$description,$type))
                throw new \Exception('Erreur lors de l\'enregistrement',2);
            try{
                file::upload($repo_path,$file,1024*1024*10,$filename);
            }catch(\Exception $e){
                PDOQueries::delete_message_attachments($id_message_attachments);
                throw $e;
            }
        }else{
            $type='other';

            $filename_before_zip = $id_message_attachments.'.'.file::file_infos($file)->extension;
            $filename = file::file_infos($file)->name;
            $path_file = $repo_path.$filename_before_zip;
            $link = MESSAGE_ATTACHMENT_PATH.$id_message_attachments.'.zip';

            if(!PDOQueries::add_message_attachment($id_message,$link,$description,$type))
                throw new \Exception('Erreur lors de l\'enregistrement',2);

            //Upload d'un fichier temporaire
            try{
                file::upload($repo_path,$file,1024*1024*10,$filename_before_zip);
            }catch(\Exception $e){
                throw $e;
            }

            //Zippage du fichier
            try{
                file::zip_file($path_file,ROOT.$link,$filename);
            }
            catch(\Exception $e){
                throw $e;
            }

            file::delete($path_file);

        }

        return true;
    }

    /**
     * Supprime toutes les pièces jointes d'un message
     * @param int $id_message
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
            if(!file::delete(ROOT.$message_attachment->link))
                $exceptions[] = new \Exception('Erreur lors de la suppression de la pièce jointe : N°'.$message_attachment->ID,2);
        }
        if(count($exceptions)!=0)
            throw new MessageException('Erreur lors de la suppression',2,$exceptions);
        return true;
    }

    /**
     * Determine si un expediteur peut envoyer un message a un destinataire
     * @param int $id_sender
     * @param int $id_dest
     * @return bool
     */
    static private function can_send_message($id_sender,$id_dest){
        $isTE = PDOQueries::isTE($id_sender);
        if($isTE && (PDOQueries::isTI($id_dest) || PDOQueries::isTE($id_dest)))
            return false;
        if($isTE){
            $students = User::get_all_students();
            foreach($students as $student){
                /** @var $student \app\StudentDatas */
                if($student->ID_TE == $id_sender && $student->ID_TI == $id_dest)
                    return true;
            }
            return false;
        }
        return true;
    }

} 