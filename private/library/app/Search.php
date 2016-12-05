<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 15/11/16
 * Time: 21:31
 */

namespace app;


use general\PDOQueries;

class Search extends \mainClass{

    /**
     * Effectue une recherche dans la liste des étudiants
     * @param string $search
     * @return array
     * @throws \Exception
     */
    static function searching_students($search){
        $user_type = Log::get_type();
        $user_id = Log::get_id();
        $datas = null;
        $response = array();

        switch($user_type){
            case 1:
                $datas = PDOQueries::search_students($search);
                break;
            case 2:
                $datas = PDOQueries::search_students_of_TE($search,$user_id);
                break;
            case 3:
                $datas = PDOQueries::search_students_of_TI($search,$user_id);
                break;
            default:
                throw new \Exception('Erreur lors de la recherche des étudiants',2);
        }

        foreach($datas as $student){
            User::init();
            $tmp = new StudentDatas();
            ReturnDatas::format_datas($student,$tmp);
            $response[] = $tmp;
        }

        if(count($response) == 0)
            throw new \Exception('Aucun résultat pour : '.$search,3);

        return $response;

    }

    /**
     * Effectue une recherche sur la liste des utilisateurs
     * @param string $search
     * @return array
     * @throws \Exception
     */
    static function searching_users($search){
        $user_type = Log::get_type();
        $user_id = Log::get_id();
        $datas = null;
        $response = array();

        if($user_type == 2)
            $datas = PDOQueries::search_users_from_TE($search,$user_id);
        else
            $datas = PDOQueries::search_users($search);

        foreach($datas as $user){
            User::init();
            $tmp = new UserDatas();
            ReturnDatas::format_datas($user,$tmp);
            $response[] = $tmp;
        }

        if(count($response) == 0)
            throw new \Exception('Aucun résultat pour : '.$search,3);

        return $response;
    }

    /**
     * Effectue une recherche sur la liste des posts
     * @param $search
     * @return array
     * @throws \Exception
     */
    static function searching_posts($search){
        $datas = PDOQueries::search_posts($search);
        $response = array();
        foreach($datas as $post){
            Timeline::init();
            $tmp = new TimelineDatas();
            ReturnDatas::format_datas($post,$tmp);
            $response[] = $tmp;
        }

        if(count($response) == 0)
            throw new \Exception('Aucun résultat pour : '.$search,3);

        return $response;
    }

    /**
     * Effectue une recherche sur la liste des messages
     * @param string $search
     * @return array
     * @throws \Exception
     */
    static function searching_messages($search){
        $datas = PDOQueries::search_messages($search);
        $response = array();
        foreach($datas as $post){
            Message::init();
            $tmp = new MessageDatas();
            ReturnDatas::format_datas($post,$tmp);
            $response[] = $tmp;
        }

        if(count($response) == 0)
            throw new \Exception('Aucun résultat pour : '.$search,3);

        return $response;
    }

} 