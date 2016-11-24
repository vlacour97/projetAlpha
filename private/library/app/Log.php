<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 26/10/16
 * Time: 13:30
 */

namespace app;


use general\crypt;
use general\mail;
use general\PDOQueries;

class Log extends \mainClass{

    static $id = 'id';
    static $lang = 'language';
    static $cookie_duration = 31104000; //1 an
    static $get_country_api_link = 'http://getcitydetails.geobytes.com/GetCityDetails?fqcn=';
    static $min_pwd_size = 8;


    /**
     * Connecte l'utilisateur
     * @param string $email
     * @param string $password
     * @param bool $check
     * @return bool
     * @throws \Exception
     */
    static function login($email,$password,$check = true){

        if(!PDOQueries::verification_connection($email,$password))
            throw new \Exception('Adresse email ou mot de passe incorrect !',2);
        if(!($id_user = PDOQueries::get_UserID_with_email($email)) || !($user_lang = PDOQueries::get_User_language($id_user)))
            throw new \Exception('Erreur lors de la connexion de l\'utilisateur',1);
        $_SESSION[self::$id] = crypt::encrypt($id_user);
        $_SESSION[self::$lang] = crypt::encrypt($user_lang);
        if($check)
        {
            setcookie(self::$id,crypt::encrypt($id_user),time()+self::$cookie_duration,'/');
            setcookie(self::$lang,crypt::encrypt($user_lang),time()+self::$cookie_duration,'/');
        }
        PDOQueries::update_last_login_user($id_user);
        return true;

    }

    /**
     * Déconnecte l'utilisateur
     */
    static function logout(){

        unset($_SESSION[self::$id]);
        setcookie(self::$id,null,time()-1);
        unset($_COOKIE[self::$id]);
    }

    /**
     * Gére un mot de passe oublié
     * @param string $email
     * @return bool
     * @throws \Exception
     */
    static function forgottenPwd($email){
        $id = PDOQueries::get_UserID_with_email($email);
        return mail::send_forgotten_password_email($id);
    }

    /**
     * Permet l'inscription d'utilisateur par un utilisateur (partie 2)
     * @param int $id
     * @param string $pwd
     * @param string $pwd_verif
     * @param string $name
     * @param string $fname
     * @param string $phone
     * @param string $address
     * @param string $zip_code
     * @param string $city
     * @param string $country
     * @param string $language
     * @return bool
     * @throws \Exception
     */
    static function registration_by_user($id,$pwd,$pwd_verif,$fname,$name,$phone = "",$address = "",$zip_code = "",$city = "",$country = "",$language = ""){
        if(!PDOQueries::userID_exist($id))
            throw new \Exception('L\'Utilisateur de demandé n\'existe pas',1);
        if(PDOQueries::is_activated($id))
            throw new \Exception('L\'Utilisateur est déjà activé',3);
        if(!is_string($pwd) || $pwd == "" || !is_string($pwd_verif) || $pwd_verif == "" || !is_string($name) || $name == "" || !is_string($fname) || $fname == "")
            throw new \Exception('Veuillez remplir les champs obligatoires',2);
        if(strlen($pwd) < self::$min_pwd_size)
            throw new \Exception('Veuillez informer un mot de passe plus long',2);
        if($pwd != $pwd_verif)
            throw new \Exception('La vérification du mot de passe n\'est pas identique au mot de passe',2);
        if($language == "")
            $language = self::get_lang();
        $email = PDOQueries::show_user($id)['email'];
        if(!is_string($email) || $email == "")
            throw new \Exception('Erreur lors de l\'enregistrement',1);
        return PDOQueries::edit_user($id,$name,$fname,$email,$phone,$address,$zip_code,$city,$country,$language) && PDOQueries::change_password($id,$pwd) && PDOQueries::activate_user($id) && mail::send_confirmation_email($id);
    }

    /**
     * Determine si un utilisateur existe
     * @param int $id
     * @return bool
     */
    static function userExist($id){
        return PDOQueries::userID_exist($id);
    }

    /**
     * Determine si l'utilisateur est connecté
     * @return bool
     */
    static function isLogged(){
        return isset($_SESSION[self::$id]) && !is_null($_SESSION[self::$id]) && self::userExist(crypt::decrypt($_SESSION[self::$id]));
    }

    /**
     * Determine s'il doit accéder au lockscreen
     * @return bool
     */
    static function need_to_lockscreen(){
        return (!isset($_SESSION[self::$id]) || is_null($_SESSION[self::$id])) && isset($_COOKIE[self::$id]) && !is_null($_COOKIE[self::$id]) && self::userExist(crypt::decrypt($_COOKIE[self::$id]));
    }


    static function change_password($id,$pwd,$pwdVerif){
        if($pwd != $pwdVerif)
            throw new \Exception('Mots de passe différents',2);
        if(!self::userExist($id))
            throw new \Exception('L\'utilisateur n\'existe pas',2);
        return User::change_password($id,$pwd);
    }

    /**
     * Récupére la langue de l'utilisateur
     * @return string
     */
    static function get_type(){
        return PDOQueries::get_User_type(self::get_id());
    }

    /**
     * Récupére la langue de l'utilisateur
     * @return string
     */
    static function get_lang(){
        if(!Install::APP_is_installed() || !self::isLogged())
            return parent::$lang;
        $lang = PDOQueries::get_User_language(self::get_id());
        if(is_null($lang) || $lang == "")
            $lang = parent::$lang;
        $lang = crypt::encrypt($lang);
        isset($_COOKIE[self::$lang]) && !is_null($_COOKIE[self::$lang]) && $lang = $_COOKIE[self::$lang];
        isset($_SESSION[self::$lang]) && !is_null($_SESSION[self::$lang]) && $lang = $_SESSION[self::$lang];
        return crypt::decrypt($lang);
    }

    /**
     * Change la langue de l'utilisateur
     * @param string $lang
     * @return bool
     */
    static function set_lang($lang){
        $_SESSION[self::$lang] = crypt::encrypt($lang);
        setcookie(self::$lang,crypt::encrypt($lang),time()+self::$cookie_duration);
        return PDOQueries::set_user_language(self::get_id(),$lang);
    }

    /**
     * Récupere l'identifiant de l'utilisateur connecté
     * @return int
     * @throws \Exception
     */
    static function get_id(){
        if((!isset($_SESSION[self::$id]) || is_null($_SESSION[self::$id])) && (!isset($_COOKIE[self::$id]) || is_null($_COOKIE[self::$id])))
            throw new \Exception('Erreur lors de la récupération de l\'identifiant',1);
        if(isset($_SESSION[self::$id]) && !is_null($_SESSION[self::$id]))
            $id = $_SESSION[self::$id];
        if(isset($_COOKIE[self::$id]) && !is_null($_COOKIE[self::$id]))
            $id = $_COOKIE[self::$id];
        return intval(crypt::decrypt($id));
    }

    /**
     * Enregistre une statistique
     * @return bool
     * @throws \Exception
     */
    static function set_stat(){
        return PDOQueries::add_statistic(self::get_id(),Navigation::get_page_id(),self::get_ip(),self::get_country(),self::get_platform(),self::get_OS(),self::get_browser());
    }

    /**
     * Permet la reconnexion sur le lockscreen
     * @param string $password
     * @throws \Exception
     */
    static function stay_connected($password){
        if(!PDOQueries::verification_id_password(self::get_id(),$password))
            throw new \PersonalizeException(2020);
        $_SESSION[self::$id] = $_COOKIE[self::$id];
        $_SESSION[self::$lang] = $_COOKIE[self::$lang];
    }

    /**
     * Récupere l'identifiant de l'OS client
     * @return string
     */
    static function get_OS(){
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $os_array = link_parameters('general/os');
        $os = 'other';

        foreach ($os_array as  $content) {

            if (preg_match($content['regex'], $user_agent)) {
                $os = $content['id'];
            }

        }

        return $os;
    }

    /**
     * Récupere l'identifiant du navigateur client
     * @return string
     */
    static function get_browser(){
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $browser_array = link_parameters('general/browsers');
        $browser = 'other';

        foreach ($browser_array as  $content) {

            if (preg_match($content['regex'], $user_agent)) {
                $browser = $content['id'];
            }

        }

        return $browser;
    }

    /**
     * Récupere l'identifiant du type de platform
     * @return string
     */
    static function get_platform(){
        $detect = new \other\Mobile_Detect();
        $platform = 'des';
        if($detect->isMobile())
            $platform = 'mob';
        if($detect->isTablet())
            $platform = 'tab';
        return $platform;
    }

    /**
     * Récupere l'ip du client
     * @return null
     */
    static function get_ip(){
        $ip = null;
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                        return $ip;
                    }
                }
            }
        }
        return $ip;
    }

    /**
     * Récupere le pays du client ou d'un ip
     * @param null|string $ip
     * @return mixed
     */
    static function get_country($ip = null){
        if(is_null($ip))
            $ip = self::get_ip();
        $json = file_get_contents(self::$get_country_api_link. $ip);
        $data = json_decode($json);
        return $data->geobytesinternet;
    }

    /**
     * Mets à jour le statut de connection
     * @throws \Exception
     */
    static function update_status(){
        PDOQueries::update_last_login_user(self::get_id());
    }

} 