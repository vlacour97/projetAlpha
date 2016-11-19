<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 26/10/16
 * Time: 13:47
 */

namespace app;

use general\Date;
use general\file;
use general\mail;
use general\PDOQueries;
use other\parseCSV;

/**
 * Class AddCSVDataException
 * @package app
 * @author Valentin Lacour
 */
Class AddCSVDataException extends \Exception{

    public $items;

    public function __construct($message = null, $code = 0, $items = array(),\Exception $previous = null){
        parent::__construct($message,$code,$previous);
        $this->items = $items;
    }

    public function getItems(){
        return $this->items;
    }

}

/**
 * Class StudentDatas
 * @package app
 * @author Valentin Lacour
 */
Class StudentDatas extends ReturnDatas{
    /**
     * @var int
     */
    public $ID;
    /**
     * @var int
     */
    public $ID_TE;
    /**
     * @var int
     */
    public $ID_TI;
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $fname;
    /**
     * @var string
     */
    public $group;
    /**
     * @var string
     */
    public $email;
    /**
     * @var string
     */
    public $phone;
    /**
     * @var string
     */
    public $address;
    /**
     * @var string
     */
    public $zip_code;
    /**
     * @var string
     */
    public $city;
    /**
     * @var string
     */
    public $country;
    /**
     * @var string
     */
    public $birth_date;
    /**
     * @var string
     */
    public $informations;
    /**
     * @var \general\Date|null
     */
    public $creation_date;
    /**
     * @var \general\Date|null
     */
    public $delete_date;
    /**
     * @var \general\Date|null
     */
    public $deadline_date;
    /**
     * @var bool
     */
    public $answered;
    /**
     * @var bool
     */
    public $answers_is_valided;
    /**
     * @var string
     */
    public $name_TE;
    /**
     * @var string
     */
    public $name_TI;
    /**
     * @var array
     */
    public $dates = ['birth_date','creation_date','delete_date','deadline_date'];
    /**
     * @var array
     */
    public $int = ['ID','ID_TE','ID_TI'];
    /**
     * @var array
     */
    public $bool = ['answered','answers_is_valided'];
    /**
     * @var array
     */
    public $useless_add_attr = ['creation_date','delete_date','answered','answers_is_valided','name_TE','name_TI'];
}

/**
 * Class UserDatas
 * @package app
 * @author Valentin Lacour
 */
Class UserDatas extends ReturnDatas{
    /**
     * @var int
     */
    public $ID;
    /**
     * @var string
     */
    public $fname;
    /**
     * @var string
     */
    public $name;
    /**
     * @var int
     */
    public $type;
    /**
     * @var string
     */
    public $email;
    /**
     * @var string
     */
    public $phone;
    /**
     * @var string
     */
    public $address;
    /**
     * @var string
     */
    public $zip_code;
    /**
     * @var string
     */
    public $city;
    /**
     * @var string
     */
    public $country;
    /**
     * @var string
     */
    public $language;
    /**
     * @var \general\Date|null
     */
    public $registration_date;
    /**
     * @var \general\Date|null
     */
    public $activation_date;
    /**
     * @var \general\Date|null
     */
    public $delete_date;
    /**
     * @var \general\Date|null
     */
    public $last_login_date;
    /**
     * @var bool
     */
    public $publication_entitled;
    /**
     * @var \general\Date|null
     */
    public $viewing_date;
    /**
     * @var int
     */
    public $ID_USER;
    /**
     * @var string
     */
    public $last_ip_viewer;
    /**
     * @var string
     */
    public $country_viewer;
    /**
     * @var string
     */
    public $platform_viewer;
    /**
     * @var string
     */
    public $os_viewer;
    /**
     * @var string
     */
    public $browser_viewer;
    /**
     * @var bool
     */
    public $activated;
    /**
     * @var array
     */
    public $int = ['ID','type','ID_USER'];
    /**
     * @var array
     */
    public $dates = ['registration_date','activation_date','delete_date','last_login_date','viewing_date'];
    /**
     * @var array
     */
    public $bool = ['publication_entitled','activated'];
    /**
     * @var array
     */
    public $useless_add_attr = ['registration_date','activation_date','delete_date','last_login_date','viewing_date','ID_USER','last_ip_viewer','country_viewer','platform_viewer','os_viewer','browser_viewer','activated'];
}

/**
 * Class User
 * @package app
 * @author Valentin Lacour
 */
class User extends \mainClass{

    /**
     * Permet l'inscription d'utilisateur par un administrateur
     * @param string $email
     * @param int $type
     * @param bool $publication_entitled
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
    static function registration_by_admin($email,$type,$publication_entitled = false,$name = "",$fname = "",$phone = "",$address = "",$zip_code = "",$city = "",$country = "",$language = ""){
        is_null($name) && $name = "";
        is_null($fname) && $fname = "";
        is_null($phone) && $phone = "";

        if(!filter_var($email,FILTER_VALIDATE_EMAIL))
            throw new \Exception('Adresse mail invalide',2);
        if(PDOQueries::verification_email($email))
            throw new \Exception('Adresse mail déjà utilisé',2);
        if(!($type>0 && $type<4))
            throw new \Exception('Type d\'utilisateur invalide',2);
        return PDOQueries::add_user($name,$fname,$type,$email,$phone,$address,$zip_code,$city,$country,$language,$publication_entitled) && mail::send_activation_email(PDOQueries::get_UserID_with_email($email));
    }

    /**
     * Permet l'ajout d'un étudiant
     * @param int $id_te
     * @param int $id_ti
     * @param string $name
     * @param string $fname
     * @param string $group
     * @param string $email
     * @param string $phone
     * @param string $address
     * @param string $zip_code
     * @param string $city
     * @param string $country
     * @param string $information
     * @param string $birth_date
     * @param null $deadline_date
     * @return bool
     * @throws \Exception
     */
    static function add_student($id_te,$id_ti,$name,$fname,$group = "",$email = "",$phone = "",$address = "",$zip_code = "",$city = "",$country = "",$information = "",$birth_date = "0000-00-00", $deadline_date = null){
        if(is_null($deadline_date))
            $deadline_date = Config::getDeadlineDate();
        if(!PDOQueries::isTE($id_te) || !PDOQueries::isTI($id_ti))
            throw new \Exception('Erreur lors de l\'ajout de l\'Étudiant',2);
        return PDOQueries::add_student($id_te,$id_ti,$name,$fname,$group,$email,$phone,$address,$zip_code,$city,$country,$information,$deadline_date,$birth_date);
    }

    /**
     * Partie 1 de l'import par CSV : Upload et Analyse
     * @param array $csv_file
     * @param int $nb_rows_begin
     * @param int $nb_cols_begin
     * @return array
     * @throws \Exception
     */
    static function upload_and_analyses_csv($csv_file,$nb_rows_begin = 0,$nb_cols_begin = 0){
        $extension = file::file_infos($csv_file)->extension;
        if($extension != 'csv')
            throw new \Exception('Le fichier n\'est pas de type CSV',2);
        if(!file::upload(TEMP_PATH,$csv_file,null,Log::get_id().'.csv'))
            throw new \Exception('Erreur lors de l\importation du fichier CSV');
        $file_path = TEMP_PATH.Log::get_id().'.csv';
        $csv_object = new parseCSV($file_path);
        $datas = array();
        foreach(array_slice($csv_object->get_datas(),0,6) as $key=>$content)
            if($key >= $nb_rows_begin)
                foreach($content as $key2=>$content2)
                    if($key2 >= $nb_cols_begin)
                        $datas[$key][$key2] = utf8_encode($content2);
        return $datas;
    }

    /**
     * Partie 2 de l'import par CSV : Enregistrement dans la BDD
     * @param array $attr_response
     * @param int $nb_rows_begin
     * @param int $nb_cols_begin
     * @throws AddCSVDataException
     * @throws \Exception
     */
    static function save_csv_datas($attr_response,$nb_rows_begin = 0,$nb_cols_begin = 0){

        //Vérification de la forme (Si étudiant email tuteurs presents)
        if(preg_grep ('/^student\/(\w+)/i', $attr_response))
            if(!preg_grep ('/^ti\/email/i', $attr_response) || !preg_grep ('/^te\/email/i', $attr_response) || !(preg_grep ('/^student\/name/i', $attr_response) && preg_grep ('/^student\/fname/i', $attr_response)))
                throw new \Exception('L\'ajout d\'un étudiant demande la présence d\'email pour les tuteurs IUT et Entreprise, ainsi que le nom et le prénom de l\'étudiant',1);

        $te_datas = array();
        $ti_datas = array();
        $students_datas = array();
        $file_path = TEMP_PATH.Log::get_id().'.csv';

        //Vérification de l'existence du fichier
        if(!is_file($file_path))
            throw new AddCSVDataException('Erreur lors de la récupération des données',2);

        $csv_object = new parseCSV($file_path);

        //On récupérer les correspondances
        foreach($attr_response as $key=>$content)
        {
            if($content == 'te/email')
                $id_cols_te_mail = $key;
            if($content == 'ti/email')
                $id_cols_ti_mail = $key;
        }

        //On sépare les données
        foreach($csv_object->get_datas() as $id_rows=>$rows){
            if($id_rows >= $nb_rows_begin)
            {
                foreach($rows as $id_cols=>$cols){
                    if($id_cols >= $nb_cols_begin)
                    {
                        if(preg_match('/^te\/(\w+)/i',$attr_response[$id_cols]))
                            $te_datas[$rows[$id_cols_te_mail]][str_replace('te/','',$attr_response[$id_cols])] = $cols;
                        if(preg_match('/^ti\/(\w+)/i',$attr_response[$id_cols]))
                            $ti_datas[$rows[$id_cols_ti_mail]][str_replace('ti/','',$attr_response[$id_cols])] = $cols;
                        if(preg_match('/^student\/(\w+)/i',$attr_response[$id_cols]))
                            $students_datas[$id_rows][str_replace('student/','',$attr_response[$id_cols])] = $cols;

                    }
                }
                $students_datas[$id_rows]['te_email'] = $rows[$id_cols_te_mail];
                $students_datas[$id_rows]['ti_email'] = $rows[$id_cols_ti_mail];
            }
        }

        $exceptions = array();

        //Requetes pour les Tuteurs Entreprises
        foreach($te_datas as $key=>$content){
            if(($te_datas[$key]['id'] = PDOQueries::get_UserID_with_email($key))== 0)
                try{
                    if(self::registration_by_admin($content['email'],2,false,$content['name'],$content['fname'],$content['phone']))
                        if(($te_datas[$key]['id'] = PDOQueries::get_UserID_with_email($key)) == 0)
                            $exceptions['te'][] = "Erreur lors de l'ajout ({$key})";
                }catch(\Exception $e){
                    $exceptions['te'][] = $e->getMessage()." ({$key})";
                }
        }

        //Requetes pour les Tuteurs IUT
        foreach($ti_datas as $key=>$content){
            if(($ti_datas[$key]['id'] = PDOQueries::get_UserID_with_email($key))== 0)
                try{
                    if(self::registration_by_admin($content['email'],3,false,$content['name'],$content['fname'],$content['phone']))
                        if(($ti_datas[$key]['id'] = PDOQueries::get_UserID_with_email($key)) == 0)
                            $exceptions['ti'][] = "Erreur lors de l'ajout ({$key})";
                }catch(\Exception $e){
                    $exceptions['ti'][] = $e->getMessage()." ({$key})";
                }
        }

        //Aménagement des données pour les étudiant + Ajout des données
        foreach($students_datas as $key=>$content){
            $id_te = $te_datas[$content['te_email']]['id'];
            $id_ti = $ti_datas[$content['ti_email']]['id'];
            $name = $content['name'];
            $fname = $content['fname'];
            if(!self::add_student($id_te,$id_ti,$content['name'],$content['fname']))
                $exceptions['student'][] = "Erreur lors de l'ajout ({$fname} {$name})";
        }

        //Suppression du fichier temporaire
        file::delete($file_path);

        if(count($exceptions['student']) == 0 && count($exceptions['ti']) == 0 && count($exceptions['te']) == 0)
            return true;
        if(count($exceptions['student']) == count($students_datas) && count($exceptions['ti']) == count($ti_datas) && count($exceptions['te']) == count($te_datas))
            throw new AddCSVDataException('Aucune données n\'a put être enregistré !',2);
        else
            throw new AddCSVDataException('Certaines données n\'ont pas put être enregistré !',1,$exceptions);
    }

    /**
     * Récupére toutes les données des Utilisateurs
     * @return array
     * @throws \Exception
     */
    static function get_all_users(){
        $datas = PDOQueries::show_all_users();
        $response = array();
        foreach($datas as $content)
        {
            self::formate_datas($content,$response[] = new UserDatas());
        }

        return $response;
    }

    /**
     * Récupére la liste des Tuteurs IUT
     * @return array
     * @throws \Exception
     */
    static function get_TI(){
        $datas = PDOQueries::show_ti_users();
        $response = array();
        foreach($datas as $content)
        {
            self::formate_datas($content,$response[] = new UserDatas());
        }

        return $response;
    }

    /**
     * Récupére la liste des Tuteur Entreprises
     * @return array
     * @throws \Exception
     */
    static function get_TE(){
        $datas = PDOQueries::show_te_users();
        $response = array();
        foreach($datas as $content)
        {
            self::formate_datas($content,$response[] = new UserDatas());
        }

        return $response;
    }

    /**
     * Récupére la liste des Utilisateurs supprimés
     * @return array
     * @throws \Exception
     */
    static function get_deleted_users(){
        $datas = PDOQueries::show_deleted_users();
        $response = array();
        foreach($datas as $content)
        {
            self::formate_datas($content,$response[] = new UserDatas());
        }

        return $response;
    }

    /**
     * Recupére toutes les données des étudiants
     * @return array
     * @throws \Exception
     */
    static function get_all_students(){
        $datas = PDOQueries::show_all_students();
        $response = array();
        foreach($datas as $content)
        {
            self::formate_datas($content,$response[] = new StudentDatas());
        }

        return $response;
    }

    /**
     * Récupére la liste des utilisateurs supprimés
     * @return array
     * @throws \Exception
     */
    static function get_deleted_students(){
        PDOQueries::show_deleted_students();
        $response = array();
        foreach($datas as $content)
        {
            self::formate_datas($content,$response[] = new StudentDatas());
        }

        return $response;
    }

    /**
     * Récupére les données d'un utilisateur
     * @param int $id
     * @return UserDatas
     * @throws \Exception
     */
    static function get_user($id){
        if(!($datas = PDOQueries::show_user($id)))
            throw new \Exception('Erreur lors de la récupération des données',2);
        $users = new UserDatas();
        self::formate_datas($datas,$users);
        return $users;
    }

    /**
     * Récupére les données d'un étudiant
     * @param int $id
     * @return StudentDatas
     * @throws \Exception
     */
    static function get_student($id){
        if(!($datas = PDOQueries::show_student($id)))
            throw new \Exception('Erreur lors de la récupération des données',2);
        $student = new StudentDatas();
        self::formate_datas($datas,$student);
        return $student;
    }

    /**
     * Formate les données des étudiants et des utilisateurs
     * @param $datas
     * @param $object
     */
    static public function formate_datas($datas,&$object){
        /** @var $object ReturnDatas */
        foreach($datas as $key=>$content){
            if(!is_int($key)){
                if(in_array($key,$object->dates) && $content != '0000-00-00 00:00:00' && $content != '0000-00-00' && $content != null)
                    $object->$key = new Date($content);
                elseif(in_array($key,$object->int))
                    $object->$key = intval($content);
                elseif(in_array($key,$object->bool))
                    $object->$key = boolval($content);
                elseif(is_null($content))
                    $object->$key = "";
                else
                    $object->$key = $content;
            }
        }
    }

    /**
     * Permet la modification d'un utilisateur
     * @param int $id
     * @param string $pwd
     * @param null string $name
     * @param null string $fname
     * @param null int $type
     * @param null string $email
     * @param null string $phone
     * @param null string $address
     * @param null string $zip_code
     * @param null string $city
     * @param null string $country
     * @param null string $language
     * @param null string $publication_entitled
     * @return bool
     * @throws \Exception
     */
    static function set_user($id,$name = null,$fname = null,$type = null,$email = null,$phone = null,$address = null,$zip_code = null,$city = null,$country = null,$language = null,$publication_entitled = null){
        $args = func_get_args();
        $user = new UserDatas();
        $datas = self::get_user($id);
        self::formate_datas_for_edit($datas,$args,$user);
        return PDOQueries::edit_user($user->ID,$user->name,$user->fname,$user->email,$user->phone,$user->address,$user->zip_code,$user->city,$user->country,$user->language);
    }

    /**
     * Permet la modification d'un étudiant
     * @param int $id
     * @param null int $id_te
     * @param null int $id_ti
     * @param null string $name
     * @param null string $fname
     * @param null string $group
     * @param null string $email
     * @param null string $phone
     * @param null string $address
     * @param null string $zip_code
     * @param null string $city
     * @param null string $country
     * @param null string $birth_date
     * @param null string $information
     * @param null string $deadline_date
     * @return bool
     * @throws \Exception
     */
    static function set_student($id,$id_te = null,$id_ti = null,$name = null,$fname = null ,$group = null,$email = null,$phone =null,$address = null,$zip_code = null,$city = null,$country = null,$birth_date = null,$information = null,$deadline_date = null){
        if((!is_null($id_te) && !PDOQueries::isTE($id_te)) || (!is_null($id_ti) && !PDOQueries::isTI($id_ti)))
            throw new \Exception('Erreur lors de la modification de l\'Étudiant',2);
        $args = func_get_args();
        $student = new StudentDatas();
        $datas = self::get_student($id);
        self::formate_datas_for_edit($datas,$args,$student);
        return PDOQueries::edit_student($student->ID,$student->ID_TE,$student->ID_TI,$student->name,$student->fname,$student->group,$student->email,$student->phone,$student->address,$student->zip_code,$student->city,$student->country,$student->birth_date,$student->informations,$student->deadline_date);
    }

    /**
     * Formate les données pour l'édition
     * @param array $datas
     * @param array $args
     * @param ReturnDatas $object
     */
    static private function formate_datas_for_edit($datas,$args,&$object){
        /** @var $object ReturnDatas */
        $iterator = 0;
        foreach($object as $key=>$content)
        {
            if(!in_array($key,$object->useless_add_attr) && !is_array($content))
            {
                if(!isset($args[$iterator]) || is_null($args[$iterator]))
                    if(is_a($datas->$key,'general\Date'))
                        $object->$key = $datas->$key->format();
                    else
                        $object->$key = $datas->$key;
                else
                    $object->$key = $args[$iterator];
                $iterator++;
            }
        }
    }

    /**
     * Supprime un utilisateur
     * @param $id
     * @return bool
     * @throws \Exception
     */
    static function delete_user($id){
        if(PDOQueries::get_User_type($id) == 1 && PDOQueries::count_admin() == 1)
            throw new \Exception('Suppression impossible : Il doit y avoir au moins un compte administrateur actif');
        return PDOQueries::delete_user($id);
    }

    /**
     * Supprime un étudiant
     * @param $id
     * @return bool
     */
    static function delete_student($id){
        return PDOQueries::delete_student($id);
    }

    /**
     * Change le mot de passe d'un utilisateur
     * @param int $id
     * @param string $pwd
     * @return bool
     */
    static function change_password($id,$pwd){
        return PDOQueries::change_password($id,$pwd);
    }

    /**
     * Autorise un utilisateur à publier
     * @param int $id
     * @return bool
     */
    static function autorised_to_publish($id){
        return PDOQueries::autorize_to_publish($id);
    }

    static function set_profile_photo($file,$id){
        try{
            return file::upload(AVATAR_IMG,$file,null,$id.'.jpg',true,'jpg');
        }catch (\Exception $e){
            throw $e;
        }
    }

    static function get_profile_photo($id){
        $path = AVATAR_IMG.'0.jpg';
        if(is_file(AVATAR_IMG.$id.'.jpg'))
            $path = AVATAR_IMG.$id.'.jpg';
        return $path;
    }

} 