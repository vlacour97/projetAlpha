<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 01/11/16
 * Time: 13:17
 */

namespace general;


use app\Config;
use app\Install;
use app\Log;
use app\Navigation;
use other\GoogleTranslate;

class Language extends \mainClass{

    static $language_dir_path = '/private/parameters/languages/';
    static $html_views_dir_path = '/private/views/';
    static $datas = null;
    static $regex_marker = '#\\{([^}]+)\\}#';

    static function init(){
       self::$datas = link_parameters('languages/'.Log::get_lang());
    }

    /**
     * Récupére les textes de dates
     * @param string|null $lang
     * @return mixed
     */
    static function get_date_text($lang = null){
        if(is_null(self::$datas) && is_null($lang))
            self::init();
        $datas = self::$datas;
        if(!is_null($lang))
            $datas = link_parameters('languages/'.$lang);
        return $datas["general"]["date"];
    }

    /**
     * Récupére les textes de mail
     * @param string|null $lang
     * @return mixed
     */
    static function get_mail_text($lang = null){
        if(is_null(self::$datas) && is_null($lang))
            self::init();
        $datas = self::$datas;
        if(!is_null($lang))
            $datas = link_parameters('languages/'.$lang);
        return $datas["general"]["mail"];
    }

    /**
     * Récupére les textes de mail
     * @param int $code
     * @param array $var
     * @param string|null $lang
     * @return mixed
     */
    static function get_exception_text($code,$var = array(),$lang = null){
        if(!is_int($code))
            return "";
        if(is_null(self::$datas) && is_null($lang))
            self::init();
        $datas = self::$datas;
        if(!is_null($lang))
            $datas = link_parameters('languages/'.$lang);
        $response = $datas["general"]["exceptions"][(string)$code];
        foreach($var as $key=>$content){
            $response = str_replace('$'.$key,$content,$response);
        }
        return $response;
    }

    /**
     * Récupére les textes de Notifications
     * @param string|null $lang
     * @return mixed
     */
    static function get_notification_texts($lang = null){
        if(is_null(self::$datas) && is_null($lang))
            self::init();
        $datas = self::$datas;
        if(!is_null($lang))
            $datas = link_parameters('languages/'.$lang);
        return $datas["general"]["notifications"];
    }

    /**
     * Récupére les textes d'une page
     * @param string $page_name
     * @return mixed
     */
    static function get_page_text($page_name){
        if(is_null(self::$datas))
            self::init();
        return self::$datas["pages"][$page_name];
    }

    /**
     * Récupére les textes d'une page
     * @param string $page_name
     * @return mixed
     */
    static function get_pdf_text($page_name){
        if(is_null(self::$datas))
            self::init();
        return self::$datas["general"]["PDF"][$page_name];
    }

    /**
     * Récupére les textes d'un composant
     * @param string $component_name
     * @return mixed
     */
    static function get_component_text($component_name){
        if(is_null(self::$datas))
            self::init();
        return self::$datas["components"][$component_name];
    }

    /**
     * Récupére les textes de météo
     * @return mixed
     */
    static function get_weather_texts(){
        if(is_null(self::$datas))
            self::init();
        return self::$datas["general"]["weather"];
    }

    /**
     * Traduit un gabarit
     * @param string $short_path
     * @return string
     * @throws \Exception
     */
    static function translate_gabarit($short_path){
        $path = ROOT.self::$html_views_dir_path.$short_path.'.html';
        if(!is_file($path))
            throw new \Exception('Le chemin demandé n\'est pas valide',1);

        //Récupération du gabarit et des textes de langue
        if(!($gabarit = file_get_contents($path)))
            throw new \Exception('Erreur lors de la récupération du contenu de la page',1);
        $part1 = explode('/',$short_path)[0];
        $part2 = explode('/',$short_path)[1];
        switch($part1){
            case 'pages':
                $language_texts = self::get_page_text($part2);
                break;
            case 'components':
                $language_texts = self::get_component_text($part2);
                break;
            case 'pdf':
                $language_texts = self::get_pdf_text($part2);
                break;
        }
        //Modification des marqueurs s'il y a lieu
        if(isset($language_texts) && !is_null($language_texts))
        {
            $marker_array = self::generate_html_marker_array($gabarit,$language_texts);
            foreach($marker_array as $key=>$content)
                $gabarit = str_replace($key,$content,$gabarit);
        }
        //Variables globales
        if(Install::APP_is_installed()){
            $lastUpdate = new Date(Config::getLastUpdate());
            $replace = array('{site-name}','{site-copyright}','{site-year}','{site_name_initial}','{logout_link}');
            $by = array(Config::getName(),Config::getCopyright(),$lastUpdate->format('yyyy'),Text::getInitials(Config::getName()),'?'.Navigation::$navigation_marker.'='.Log::$logout_marker);
            $gabarit = str_replace($replace,$by,$gabarit);
        }

        return $gabarit;
    }

    /**
     * Génére un tableau de contenu pour les textes d'un gabarit
     * @param string $gabarit
     * @param array $language_text
     * @return array
     */
    static private function generate_html_marker_array($gabarit,$language_text){
        $datas = self::get_gabarit_markers($gabarit);
        $marker_array = array();
        foreach($datas as $key)
        {
            $current_content = explode('/',$key);
            $content = $language_text;
            foreach($current_content as $part)
                $content = $content[$part];
            if(!is_null($content))
                $marker_array['{'.$key.'}'] = $content;
        }
        return $marker_array;
    }

    /**
     * Récupére les marqueurs d'un gabarit
     * @param string $gabarit
     * @return mixed
     */
    static private function get_gabarit_markers($gabarit){
        preg_match_all(self::$regex_marker, $gabarit, $datas);
        return $datas[1];
    }

    /**
     * Traduit un text par le biais de Google Translate
     * @param string $text
     * @param null|string $source
     * @param null|string $target
     * @return string
     */
    static function translate_text($text,$source = null,$target = null)
    {
        if(is_null($target))
            $target = Log::get_lang();
        if(is_null($source))
            $source = \mainClass::$lang;
        $target = substr($target,0,2);
        $source = substr($source,0,2);
        return GoogleTranslate::translate($source,$target,$text);
    }

} 