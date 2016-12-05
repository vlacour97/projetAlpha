<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 29/10/16
 * Time: 19:08
 */

namespace app;


use general\Date;

class Config {

    static $config_file_path = '/private/parameters/';
    static $config_file_name = 'app_config';

    static private $name;
    static private $description;
    static private $keywords;
    static private $author;
    static private $copyright = "Gestion Stage&copy;";
    static private $version = "1.0";
    static private $last_update;
    static private $admin_mail;
    static private $current_survey = null;
    static private $deadline_date;
    static private $default_language = "fr_FR";
    static private $weather_API_key;
    static private $check = false;

    /**
     * Crée un fichier de configuration
     * @param $name
     * @param $description
     * @param $keywords
     * @param $author
     * @param $admin_mail
     * @param $deadline_date
     * @return bool
     */
    public static function create_config_file($name,$description,$keywords,$author,$admin_mail,$deadline_date,$weather_API_key){
        $now = new Date('now');
        self::$name = $name;
        self::$description = $description;
        self::$keywords = $keywords;
        self::$author = $author;
        self::$last_update = $now->format('yyyy-mm-dd');
        self::$admin_mail = $admin_mail;
        self::$deadline_date = $deadline_date;
        self::$weather_API_key = $weather_API_key;
        return self::set_datas();
    }

    /**
     * Récupére toutes les données
     */
    private static function get_datas(){
        if(!Install::config_file_exist())
            return self::$check = true || false;
        $datas = link_parameters(self::$config_file_name);
        self::$name = $datas['name'];
        self::$description = $datas['description'];
        self::$keywords = $datas['keywords'];
        self::$author = $datas['author'];
        self::$copyright = $datas['copyright'];
        self::$version = $datas['version'];
        self::$last_update = $datas['last_update'];
        self::$admin_mail = $datas['admin_mail'];
        self::$current_survey = $datas['current_survey'];
        self::$deadline_date = $datas['deadline_date'];
        self::$default_language = $datas['default_language'];
        self::$weather_API_key = $datas['weather_API_key'];
        self::$check = true;
    }

    /**
     * Enregistre les données
     * @return bool
     */
    private static function set_datas(){
        $datas = array();
        $datas['name'] = self::$name;
        $datas['description'] = self::$description;
        $datas['keywords'] = self::$keywords;
        $datas['author'] = self::$author;
        $datas['copyright'] = self::$copyright;
        $datas['version'] = self::$version;
        $datas['last_update'] = self::$last_update;
        $datas['admin_mail'] = self::$admin_mail;
        $datas['current_survey'] = self::$current_survey;
        $datas['deadline_date'] = self::$deadline_date;
        $datas['default_language'] = self::$default_language;
        $datas['weather_API_key'] = self::$weather_API_key;
        return boolval(file_put_contents(ROOT.self::$config_file_path.self::$config_file_name.'.json',json_encode($datas)));
    }

    /**
     * @return string
     */
    public static function getAdminMail()
    {
        if(!self::$check)
            self::get_datas();
        return self::$admin_mail;
    }

    /**
     * @return string
     */
    public static function getAuthor()
    {
        if(!self::$check)
            self::get_datas();
        return self::$author;
    }

    /**
     * @return string
     */
    public static function getCopyright()
    {
        if(!self::$check)
            self::get_datas();
        return self::$copyright;
    }

    /**
     * @return int
     */
    public static function getCurrentSurvey()
    {
        if(!self::$check)
            self::get_datas();
        return self::$current_survey;
    }

    /**
     * @return string
     */
    public static function getDeadlineDate()
    {
        if(!self::$check)
            self::get_datas();
        return self::$deadline_date;
    }

    /**
     * @return string
     */
    public static function getDescription()
    {
        if(!self::$check)
            self::get_datas();
        return self::$description;
    }

    /**
     * @return string
     */
    public static function getKeywords()
    {
        if(!self::$check)
            self::get_datas();
        return self::$keywords;
    }

    /**
     * @return string
     */
    public static function getLastUpdate()
    {
        if(!self::$check)
            self::get_datas();
        return self::$last_update;
    }

    /**
     * @return string
     */
    public static function getName()
    {
        if(!self::$check)
            self::get_datas();
        return self::$name;
    }

    /**
     * @return string
     */
    public static function getVersion()
    {
        if(!self::$check)
            self::get_datas();
        return self::$version;
    }

    /**
     * @return string
     */
    public static function getDefaultLanguage()
    {
        if(!self::$check)
            self::get_datas();
        return self::$default_language;
    }

    /**
     * @return mixed
     */
    public static function getWeatherAPIKey()
    {
        if(!self::$check)
            self::get_datas();
        return self::$weather_API_key;
    }

    /**
     * @param mixed $admin_mail
     * @return bool
     */
    public static function setAdminMail($admin_mail)
    {
        if(!self::$check)
            self::get_datas();
        self::$admin_mail = $admin_mail;
        return self::set_datas();
    }

    /**
     * @param mixed $author
     * @return bool
     */
    public static function setAuthor($author)
    {
        if(!self::$check)
            self::get_datas();
        self::$author = $author;
        return self::set_datas();
    }

    /**
     * @param mixed $copyright
     * @return bool
     */
    public static function setCopyright($copyright)
    {
        if(!self::$check)
            self::get_datas();
        self::$copyright = $copyright;
        return self::set_datas();
    }

    /**
     * @param mixed $current_survey
     * @return bool
     */
    public static function setCurrentSurvey($current_survey)
    {
        if(!self::$check)
            self::get_datas();
        self::$current_survey = $current_survey;
        return self::set_datas();
    }

    /**
     * @param mixed $deadline_date
     * @return bool
     */
    public static function setDeadlineDate($deadline_date)
    {
        if(!self::$check)
            self::get_datas();
        self::$deadline_date = $deadline_date;
        return self::set_datas();
    }

    /**
     * @param mixed $description
     * @return bool
     */
    public static function setDescription($description)
    {
        if(!self::$check)
            self::get_datas();
        self::$description = $description;
        return self::set_datas();
    }

    /**
     * @param mixed $keywords
     * @return bool
     */
    public static function setKeywords($keywords)
    {
        if(!self::$check)
            self::get_datas();
        self::$keywords = $keywords;
        return self::set_datas();
    }

    /**
     * @param mixed $last_update
     * @return bool
     */
    public static function setLastUpdate($last_update)
    {
        if(!self::$check)
            self::get_datas();
        self::$last_update = $last_update;
        return self::set_datas();
    }

    /**
     * @param mixed $name
     * @return bool
     */
    public static function setName($name)
    {
        if(!self::$check)
            self::get_datas();
        self::$name = $name;
        return self::set_datas();
    }

    /**
     * @param mixed $version
     * @return bool
     */
    public static function setVersion($version)
    {
        if(!self::$check)
            self::get_datas();
        self::$version = $version;
        return self::set_datas();
    }

    /**
     * @param string $default_language
     * @return bool
     */
    public static function setDefaultLanguage($default_language){
        if(!self::$check)
            self::get_datas();
        self::$default_language = $default_language;
        return self::set_datas();
    }

    /**
     * @param mixed $weather_API_key
     * @return bool
     */
    public static function setWeatherAPIKey($weather_API_key)
    {
        if(!self::$check)
            self::get_datas();
        self::$weather_API_key = $weather_API_key;
        return self::set_datas();
    }


} 