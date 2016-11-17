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

class ReturnDatas{
    public $int = array();
    public $date = array();
    public $bool = array();
    public $ban = array();
}

class CommentsDatas extends ReturnDatas{

    public $ID;
    public $ID_POST;
    public $ID_USER;
    public $content;

    /**
     * @var \general\Date
     */
    public $publication_date;
    public $comment_name;
    public $int = array('ID','ID_POST','ID_USER');
    public $date = array('publication_date');
    public $ban = array('deleted');
}

class LikesDatas extends ReturnDatas{
    public $ID;
    public $ID_POST;
    public $ID_USER;
    public $requested_date;
    public $liker_name;
    public $int = array('ID','ID_POST','ID_USER');
    public $date = array('requested_date');

}

class PostAtttachmentDatas{

    public $link;
    public $description;

    function __construct($link,$description)
    {
        $this->link = $link;
        $this->description = $description;
    }
}
class TimelineDatas{

    public $id_post;
    public $fname;
    public $name;
    public $id_user;
    public $content;
    public $publication_date;
    public $post_attachments; //tableau d'objets
    public $comments;
    public $likes;

    /* function __construct($id_post,$fname,$name,$id_user,$content,$publication_date)
    {
        $this->id_post = $id_post;
        $this->fname = $fname;
        $this->name = $name;
        $this->id_user = $id_user;
        $this->content = $content;
        $this->publication_date = $publication_date;
        $this->post_attachments = array();
        $this->comments = array();
        $this->likes = array();
    }
    */




    function afficher(){
        foreach($this as $key => $value) {
            print "$key => $value\n";
        }
    }
}

class Timeline extends \mainClass{

    //Niveau 3
    static function get_all_posts(){
        //TODO Récupére toutes les publications et les renvois sous la forme d'un tableau avec des données formattés (cf show_post)
    }

    //Niveau 2
    /**
     * Permet l'ajout d'un post en prenant en compte les piéces jointes
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

    //TODO mettre en private

    static function save_post_attachments($id_post,$file,$description = null){
        //récupération du type
        $type = file::file_infos($file)->type;

        is_null($description) && $description = "";

        if($type == "image"){

            try{
                file::upload(POST_CONTENT,$file,1024*1024*10,$id_post.'.jpg');
            }catch(\Exception $e){
                throw $e;
            }

            $link = POST_CONTENT.'/'.$id_post.'.jpg';
        }else{
            $type = 'other';
            try{
                file::upload(POST_CONTENT,$file,1024*1024*10);
            }catch(\Exception $e){
                throw $e;
            }
            $path_file = POST_CONTENT.'/'.$file['name'];
            $link = POST_CONTENT.'/'.$id_post.'.zip';
            try{
                file::zip_file($path_file,$link);
            }
            catch(\Exception $e){
                throw $e;
            }

            file::delete($path_file);
        }

        return PDOQueries::add_post_attachement($id_post, $link, $description, $type);
    }

    /**
     *  Récupere les pieces jointes sur la base et renvoi un tableau avec ses informations (chemin d'accés, infos BD)
     * @param $id_post
     * @return array|bool
     */
    static private function get_post_attachment($id_post){
        return PDOQueries::show_post_attachment($id_post);
    }

    //Niveau 2
    static private function get_post(){

        //show_post_attachment                      format_datas
        //getComments foreach show_comment          format_datas
        //getLikes foreach show_likes               format_datas
        //TODO Mets en forme la présentation des valeurs de retour pour un post

    }

    /**
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
