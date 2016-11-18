<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 26/10/16
 * Time: 13:50
 */

namespace app;


use general\Date;
use general\file;
use general\PDOQueries;

/**
 * Class ReturnDatas
 * @package app
 * @author Rémi Lemaire
 */
class ReturnDatas{
    /** @var array  */
    public $int = array();
    /** @var array */
    public $date = array();
    /** @var array */
    public $bool = array();
    /** @var array */
    public $ban = array();
}

/**
 * Class CommentsDatas
 * @package app
 * Author: Rémi Lemaire
 */
class CommentsDatas extends ReturnDatas{
    /** @var int */
    public $ID;
    /** @var int */
    public $ID_POST;
    /** @var int */
    public $ID_USER;
    /** @var string */
    public $content;

    /** @var \general\Date */
    public $publication_date;
    /** @var  string */
    public $comment_name;
    /** @var array  */
    public $int = array('ID','ID_POST','ID_USER');
    /** @var array  */
    public $date = array('publication_date');
    /** @var array  */
    public $ban = array('deleted');

}

/**
 * Class LikesDatas
 * @package app
 * Author : Rémi Lemaire
 */
class LikesDatas extends ReturnDatas{
    /** @var int */
    public $ID;
    /** @var int */
    public $ID_POST;
    /** @var int */
    public $ID_USER;
    /** @var  \general\Date */
    public $requested_date;
    /** @var  string */
    public $liker_name;
    /** @var array  */
    public $int = array('ID','ID_POST','ID_USER');
    /** @var array  */
    public $date = array('requested_date');

}

/**
 * Class PostAtttachmentDatas
 * @package app
 * Author : Rémi Lemaire
 */
class PostAtttachmentDatas extends ReturnDatas{
    /** @var  int */
    public $ID;
    /** @var  int */
    public $ID_POST;
    /** @var  string */
    public $link;
    /** @var  string */
    public $description;
    /** @var  string */
    public $type_file;
    /** @var array  */
    public $int = array('ID','ID_POST');

}

/**
 * Class TimelineDatas
 * @package app
 * Author : Rémi Lemaire
 */
class TimelineDatas extends ReturnDatas{
    /** @var  int */
    public $ID;
    /** @var  int */
    public $ID_USER;
    /** @var  string */
    public $content;
    /** @var  string */
    public $deleted;
    /** @var  \general\Date */
    public $publication_date;
    /** @var  string */
    public $post_name;
    /** @var array  */
    public $likes= array();
    /** @var array  */
    public $comments = array();
    /** @var array  */
    public $post_attachments = array();
    /** @var array  */
    public $int = array('ID','ID_USER');
    /** @var array  */
    public $date = array('publication_date');
    /** @var array  */
    public $ban = array('deleted');



}

/**
 * Class Timeline
 * @package app
 * Author : Rémi Lemaire
 */
class Timeline extends \mainClass{

    /** @var string  */
    static $post_id_page = "timeline";


    /**
     * Récupère toutes les publications et les renvoit sous la forme d'un tableau avec des données formattées (cf show_post)
     * @return array
     */
    static function get_all_posts(){
        $datas = PDOQueries::show_all_posts();
        $posts = array();
        foreach($datas as $content){
            $posts[]= self::get_post($content);
        }
        return $posts;

    }

    /**
     * Permet l'ajout d'un post en prenant en compte les pièces jointes
     * @param $id_user
     * @param $content
     * @param null $post_attachment
     * @param null $description
     * @return bool
     * @throws \Exception
     */
    static function add_post($id_user,$content,$post_attachment = null,$description = null){

        //ajout de poste
        if(!PDOQueries::add_post($id_user, $content))
            throw new \Exception('Erreur lors de l\'ajout de la publication',2);

        //récup id
        $id_post = PDOQueries::get_max_post_id();


        //fonction savepost


        if((is_array($post_attachment) && self::save_post_attachments($id_post, $post_attachment, $description)) || is_null($post_attachment)){
            try{
                return true;
            }catch(\Exception $e){
                throw $e;
            }
        }
    }

    /**
     *  permet de supprimer un post
     * @param int $id_post
     * @return bool
     */
    static function remove_post($id_post){
        return PDOQueries::delete_post($id_post);
    }

    /**
     * Permet l'ajout d'un commentaire
     * @param $id_post
     * @param $id_user
     * @param $content
     * @return bool
     */
    static function add_comment($id_post,$id_user,$content){
        return PDOQueries::add_comment($id_post, $id_user, $content);
    }

    /**
     * supprime un commentaire
     * @param $id_comment
     * @return bool
     */
    static function delete_comment($id_comment){
        return PDOQueries::delete_comment($id_comment);
    }

    /**
     * ajoute un like
     * @param $id_post
     * @param $id_user
     * @return bool
     */
    static function like($id_post,$id_user){
        return PDOQueries::like_post($id_post,$id_user);
    }

    /**
     * Permet la suppression d'un like
     * @param $id_post
     * @param $id_user
     * @return bool
     */
    static function unlike($id_post,$id_user){
        return PDOQueries::unlike_post($id_post,$id_user);
    }

    /**
     * permet la sauvegarde d'upload de pièce jointe
     * @param $id_post
     * @param $file
     * @param null $description
     * @return bool
     * @throws \Exception
     */
    static function save_post_attachments($id_post,$file,$description = null){
        //récupération du type
        $type = file::file_infos($file)->type;
        //Récupération de l'identifiant de la future piéce jointe sur la BDD
        $id_post_attachment = PDOQueries::get_maxID_post_attachment() + 1;

        is_null($description) && $description = "";

        if($type == "image"){
            //Si c'est une image, on upload l'image
            $filename = $id_post_attachment.'.jpg';
            try{
                file::upload(POST_CONTENT,$file,1024*1024*10,$filename);
            }catch(\Exception $e){
                throw $e;
            }

            $link = POST_CONTENT.$filename;
        }else{
            //Sinon, on upload le contenu et on le mets dans un fichier zip
            $type = 'other';

            //Génération de parametres
            $filename_before_zip = $id_post_attachment.'.'.file::file_infos($file)->extension;
            $filename = file::file_infos($file)->name;
            $path_file = POST_CONTENT.$filename_before_zip;
            $link = POST_CONTENT.$id_post_attachment.'.zip';

            //Upload d'un fichier temporaire
            try{
                file::upload(POST_CONTENT,$file,1024*1024*10,$filename_before_zip);
            }catch(\Exception $e){
                throw $e;
            }

            //Zippage du fichier
            try{
                file::zip_file($path_file,$link,$filename);
            }
            catch(\Exception $e){
                throw $e;
            }

            //Suppression du fichier temporaire
            file::delete($path_file);
        }

        return PDOQueries::add_post_attachement($id_post, $link, $description, $type);
    }

    /**
     *  Récupere les pieces jointes sur la base et renvoie un tableau avec ses informations (chemin d'accés, infos BD)
     * @param $id_post
     * @return array|bool
     */
    static private function get_post_attachments($id_post_attachment){
        $datas = PDOQueries::show_post_attachment($id_post_attachment);
        $attachments = array();
        foreach($datas as $key=>$lines){
            $tmp = new PostAtttachmentDatas();
            self::format_datas($lines,$tmp);
            $attachments[]= $tmp;
        }

        return $attachments;
    }

    /**
     * Met en forme la présentation des valeurs de retour pour un post
     * @param array $postDatas
     * @return TimelineDatas
     */
    static private function get_post($postDatas=array()){
        $post= new TimelineDatas();
        self::format_datas($postDatas,$post);

        //show_post_attachment
        $post->post_attachments =self::get_post_attachments($post->ID);

        //getComments
        $post->comments=self::get_comments($post->ID);

        //getLikes
        $post->likes=self::get_likes($post->ID);

        return $post;
    }

    /**
     * Met en forme la présentation des valeurs de retour pour un commentaire
     * @param $id_post_comments
     * @return array
     */
    static private function get_comments($id_post_comments)
    {
        $datas = PDOQueries::show_comment($id_post_comments);
        $comments = array();
        foreach ($datas as $key=>$lines) {
            $tmp = new CommentsDatas();
            self::format_datas($lines,$tmp);
            $comments[] = $tmp;
        }
        return $comments;
    }

    /**
     * Met en forme la présentation des valeurs de retour pour un like
     * @param $id_post_likes
     * @return array
     */
    static private function get_likes($id_post_likes){
        $datas = PDOQueries::show_likes($id_post_likes);
        $likes = array();
        foreach ($datas as $key=>$lines){
            $tmp = new LikesDatas();
            self::format_datas($lines,$tmp);
            $likes[] = $tmp;
        }
        return $likes;
    }

    /**
     * formattage de données
     * @param array $datas
     * @param ReturnDatas $object
     */
    static public function format_datas($datas,&$object){

        foreach ($datas as $key=>$content) {
            if(is_string($key) && !in_array($key,$object->ban)){
                if(in_array($key,$object->int))
                    $object->$key=intval($content);
                elseif(in_array($key,$object->date))
                    $object->$key=new \general\Date($content);
                elseif(in_array($key,$object->bool))
                    $object->$key=boolval($content);
                else
                    $object->$key=$content;
            }

        }
    }

}
