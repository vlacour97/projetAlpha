<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 26/10/16
 * Time: 13:50
 */

namespace app;


use general\file;
use general\PDOQueries;

class Timeline extends \mainClass{

    //Niveau 3
    static function get_all_posts(){
        //TODO Récupére toutes les publications et les renvois sous la forme d'un tableau avec des données formattés (cf show_post)
    }

    //Niveau 2
    static function add_post($id_user,$content,$post_attachment = array()){

        //ajout de poste
        PDOQueries::add_post($id_user, $content);

        //récup id
        $id_post = 1;

       //fonction savepost





        //TODO Permet l'ajout d'un post en prenant en compte les piéces jointes
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
    static function save_post_attachments($id_post,$file,$description = ""){
        //récupération du type
        $type = file::file_infos($file)->type;

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
    static private function get_post($id,$fname,$name,$content,$publication_date){
        //TODO Mets en forme la présentation des valeurs de retour pour un post
    }

} 