<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 27/10/16
 * Time: 14:51
 */

namespace app;


use general\Language;
use general\PDOQueries;

/**
 * Class NavLine
 * @package app
 * @author Valentin Lacour
 */
class NavLine{
    /**
     * @var string Identifiant de la page
     */
    public $id;
    /**
     * @var string Nom de la page
     */
    public $name;
    /**
     * @var string Logo de la page
     */
    public $logo;
    /**
     * @var string Lien vers la page
     */
    public $link;
    /**
     * @var array/NavLine Table des lignes de navigation
     */
    public $navPage;
}

class Navigation extends \mainClass{

    static $pages_datas_files = "app/page_datas";
    static $navigation_marker = "nav";
    static $navigation_separator = "/";
    static $default_page = "home";
    static $page_datas;
    static $rights;
    static $autorised_pages;
    static $isInit = false;

    /**
     * Initialise l'objet
     */
    static function init(){
        self::$isInit = true;
        self::$page_datas = link_parameters('app/page_datas');
        self::$rights = link_parameters('app/rights');
        self::$autorised_pages = self::autorised_pages();
    }

    /**
     * Recupére la page demandé par le client
     */
    static function get_pages(){
        $nav = self::get_page_id();

        if(!self::isAutorised($nav))
            header('Location: '.HOST.'/index.php?nav='.self::$default_page);

        include_once PATH_CONTROLLER.$nav.'.php';
    }

    /**
     * Récupére la barre de navigation
     * @return array/NavLine
     */
    static function get_navbar(){
        if(!self::$isInit)
            self::init();
        $response = array();
        $page_datas = self::$page_datas;
        $autorised_pages = self::autorised_pages();
        $page_name = Language::get_page_name();

        foreach($page_datas as $key=>$content)
        {
            if(!is_null($content['pages']) && is_array($content['pages']))
            {
                $temp_array = array();
                $autorised_part = false;
                foreach($content['pages'] as $content2){
                    if(in_array($content['id'].self::$navigation_separator.$content2['id'],$autorised_pages) && $content2['inNavigation'])
                    {
                        $temp = new NavLine();
                        $temp->id = $content2['id'];
                        $temp->name = $page_name[$content['id'].'/'.$content2['id']];
                        $temp->logo = $content2['logo'];
                        $temp->link = '?'.self::$navigation_marker.'='.$content['id'].self::$navigation_separator.$content2['id'];
                        $temp_array[] = $temp;
                        $autorised_part = true;
                    }
                }
                if($autorised_part)
                {
                    $temp = new NavLine();
                    $temp->id = $content['id'];
                    $temp->name = $page_name[$content['id']];
                    $temp->logo = $content['logo'];
                    $temp->link = '#';
                    $temp->navPage = $temp_array;
                    $response[$key] = $temp;
                }
            }
            else
                if(in_array($content['id'],$autorised_pages) && $content['inNavigation']){
                    $temp = new NavLine();
                    $temp->id = $content['id'];
                    $temp->name = $page_name[$content['id']];
                    $temp->logo = $content['logo'];
                    $temp->link = '?'.self::$navigation_marker.'='.$content['id'];
                    $response[$key] = $temp;
                }
        }
        return $response;
    }

    /**
     * Récupére les pages autorisés
     * @return array
     */
    static private function autorised_pages(){
        if(!self::$isInit)
            self::init();
        $user_type = Log::get_type();
        foreach(self::$rights as $content){
            if($content['id'] == $user_type)
                return $content['rights'];
        }
        return array();
    }

    /**
     * Determine si une page est autorisé ou non
     * @param string $page_name
     * @return bool
     */
    static function isAutorised($page_name){
        return in_array($page_name,self::autorised_pages());
    }

    /**
     * Récupére l'identifiant d'une page
     * @return string
     */
    static function get_page_id(){
        $nav = $_GET[self::$navigation_marker];
        if($nav == '')
            $nav = self::$default_page;
        if(!self::issetPage($nav)){
            header('Location: '.HOST.'?nav='.self::$default_page);
            $nav = self::$default_page;
        }
        return $nav;
    }

    /**
     * Determine si une page existe ou non
     * @param string $page_name
     * @return bool
     */
    static private function issetPage($page_name){
        if(!self::$isInit)
            self::init();
        $response = false;
        foreach(self::$page_datas as $content)
        {
            if(!is_null($content['pages']) && is_array($content['pages']))
            {
                foreach($content['pages'] as $content2){
                    if($content['id'].self::$navigation_separator.$content2['id'] == $page_name)
                        $response = true;
                }
            }
            else
                if($content['id'] == $page_name)
                    $response = true;
        }
        return $response;
    }

    /**
     * Récupére le titre de la page
     * @return mixed
     */
    static function get_title(){
        if(!self::$isInit)
            self::init();
        $idPage = self::get_page_id();
        return Language::get_page_name()[$idPage];
    }

    /**
     * Récupére le chemin vers la page
     * @return array
     */
    static function get_path(){
        $idPage = self::get_page_id();
        return explode(self::$navigation_separator,$idPage);
    }

} 