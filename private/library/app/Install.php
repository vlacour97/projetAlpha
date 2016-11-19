<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 27/10/16
 * Time: 14:43
 */

namespace app;


use general\PDOQueries;

/**
 * Class Install
 * @package app
 * @author Valentin Lacour
 */
class Install {

    static $config_PDO_file = "/private/parameters/app/db_datas.json";
    static private $SQL_install_script = "/private/parameters/app/install.sql";
    static private $db_datas_path = "/private/parameters/app/db_datas.json";
    static $isInit = false;
    static $step = 0;

    /**
     * Determine si l'application est installé
     * @return bool
     */
    static function APP_is_installed(){
        return self::get_step() == 4;
    }

    /**
     * Récupére les étape de l'installation
     * @return int
     */
    static function get_step(){
        if(!self::$isInit)
        {
            if(!is_file(ROOT.self::$db_datas_path)){
                self::$step = 0;
                return self::$step;
            }

            if(!is_file(ROOT.config::$config_file_path.config::$config_file_name.'.json')){
                self::$step = 1;
                return self::$step;
            }

            PDOQueries::init();

            if(PDOQueries::count_users() == 0){
                self::$step = 2;
                return self::$step;
            }

            if(Answer::count_surveys() == 0){
                self::$step = 3;
                return self::$step;
            }

            self::$step = 4;

        }

        return self::$step;
    }

    /**
     * Permet l'installation de la base de données
     * @param string $host
     * @param string $dbname
     * @param string $user
     * @param string $password
     * @param string $prefix
     * @return bool
     * @throws \Exception
     */
    static function PDO_install($host,$dbname,$user,$password,$prefix = ""){
        if(strpos($prefix,' '))
            throw new \Exception('Veuillez ne pas insérer d\'espace dans le préfixe ! ',1);

        //Test de connexion
        try{
            $PDO = self::PDO_connect($host,$dbname,$user,$password,true);
        }catch (\Exception $e){
            throw $e;
        }

        //Préparation du script SQL
        try{
            $script = file_get_contents(ROOT.self::$SQL_install_script);
        }catch (\Exception $e){
            throw new \Exception('Fichier non trouvé');
        }
        $script = str_replace('{prefix}',$prefix,$script);

        //Execution du script SQL
        /** @var $PDO \PDO */
        if(!$PDO->prepare($script)->execute())
            throw new \Exception('Erreur lors de l\'importation des données',2);

        //Création du fichier de configuration
        try{
            self::create_db_datas_file($host,$dbname,$user,$password,$prefix);
            self::$isInit = true;
            self::$step = 1;
        }catch (\Exception $e){
            throw $e;
        }

        return true;
    }

    /**
     * Configure le fichier app_config
     * @param string $name
     * @param string $description
     * @param string $keywords
     * @param string $author
     * @param string $admin_mail
     * @param string $deadline_date
     * @param string $weather_API_Key
     * @throws \Exception
     */
    static function Config_install($name,$description,$keywords,$author,$admin_mail,$deadline_date,$weather_API_Key){
        try{
            Config::create_config_file($name,$description,$keywords,$author,$admin_mail,$deadline_date,$weather_API_Key);
        }catch (\Exception $e){
            throw $e;
        }

    }

    /**
     * Ajoute le premier administrateur sur le site
     * @param string $email
     * @param string $name
     * @param string $fname
     * @param string $phone
     * @param string $address
     * @param string $zip_code
     * @param string $city
     * @param string $country
     * @param string $language
     * @throws \Exception
     */
    static function Admin_install($email,$name,$fname,$pwd,$pwdTest,$phone = "",$address = "",$zip_code = "",$city = "",$country = "",$language = ""){
        try{
            User::registration_by_admin($email,1,true,$name,$fname,$phone,$address,$zip_code,$city,$country,$language,false);
            $id_user = PDOQueries::get_UserID_with_email($email);
            Log::registration_by_user($id_user,$pwd,$pwdTest,$fname,$name,$phone,$address,$zip_code,$city,$country,$language);
        }catch (\Exception $e){
            throw $e;
        }

    }

    /**
     * Installe le premier questionnaire
     * @throws \Exception
     */
    static function Survey_install(){
        $survey = array(
            0 => array(
                "questionLbl" => "Le stagiaire a-t-il été ponctuel ?",
                1 => array(
                    "lbl" => "Oui",
                    "nb_point" => 1
                ),
                2 => array(
                    "lbl" => "Non",
                    "nb_point" => 0
                )
            ),
            1 => array(
                "questionLbl" => "Le stagiaire a-t-il fait preuve d’assiduité ?",
                1 => array(
                    "lbl" => "Oui",
                    "nb_point" => 1
                ),
                2 => array(
                    "lbl" => "Non",
                    "nb_point" => 0
                )
            ),
            2 => array(
                "questionLbl" => "Le stagiaire a-t-il su s’intégrer à son environnement de travail ?",
                1 => array(
                    "lbl" => "Oui",
                    "nb_point" => 1
                ),
                2 => array(
                    "lbl" => "Non",
                    "nb_point" => 0
                )
            ),
            3 => array(
                "questionLbl" => "Le stagiaire a-t-il fait preuve de sociabilité ?",
                1 => array(
                    "lbl" => "Oui",
                    "nb_point" => 1
                ),
                2 => array(
                    "lbl" => "Non",
                    "nb_point" => 0
                )
            ),
            4 => array(
                "questionLbl" => "Le stagiaire a-t-il fait preuve de respect envers ses collègues et ses supérieurs ?",
                1 => array(
                    "lbl" => "Oui",
                    "nb_point" => 1
                ),
                2 => array(
                    "lbl" => "Non",
                    "nb_point" => 0
                )
            ),
            5 => array(
                "questionLbl" => "Le stagiaire a-t-il su être organisé et méthodique dans son travail ?",
                1 => array(
                    "lbl" => "Oui",
                    "nb_point" => 1
                ),
                2 => array(
                    "lbl" => "Non",
                    "nb_point" => 0
                )
            ),
            6 => array(
                "questionLbl" => "Le stagiaire a-t-il su effectuer les tâches qu’on lui a demandées ?",
                1 => array(
                    "lbl" => "Oui",
                    "nb_point" => 1
                ),
                2 => array(
                    "lbl" => "Non",
                    "nb_point" => 0
                )
            ),
            7 => array(
                "questionLbl" => "Le stagiaire a-t-il su s’exprimer d’une manière compréhensible et pertinente ?",
                1 => array(
                    "lbl" => "Oui",
                    "nb_point" => 1
                ),
                2 => array(
                    "lbl" => "Non",
                    "nb_point" => 0
                )
            ),
            8 => array(
                "questionLbl" => "Le stagiaire a-t-il su mettre en pratique ses connaissances techniques ?",
                1 => array(
                    "lbl" => "Oui",
                    "nb_point" => 1
                ),
                2 => array(
                    "lbl" => "Non",
                    "nb_point" => 0
                )
            ),
            9 => array(
                "questionLbl" => "Le stagiaire a-t-il su fournir un travail de qualité ?",
                1 => array(
                    "lbl" => "Oui",
                    "nb_point" => 1
                ),
                2 => array(
                    "lbl" => "Non",
                    "nb_point" => 0
                )
            ),
            10 => array(
                "questionLbl" => "Le stagiaire a-t-il su prendre des initiatives, des décisions (faire preuve d’autonomie) ?",
                1 => array(
                    "lbl" => "Oui",
                    "nb_point" => 1
                ),
                2 => array(
                    "lbl" => "Non",
                    "nb_point" => 0
                )
            ),
            11 => array(
                "questionLbl" => " Le stagiaire s’est-il intéressé et impliqué ? (poser des questions, …)",
                1 => array(
                    "lbl" => "Oui",
                    "nb_point" => 1
                ),
                2 => array(
                    "lbl" => "Non",
                    "nb_point" => 0
                )
            ),
            12 => array(
                "questionLbl" => "Le stagiaire a-t-il su mettre en application les conseils de l’équipe ?",
                1 => array(
                    "lbl" => "Oui",
                    "nb_point" => 1
                ),
                2 => array(
                    "lbl" => "Non",
                    "nb_point" => 0
                )
            ),
            13 => array(
                "questionLbl" => "Le stagiaire a-t-il eu l’esprit d’équipe ?",
                1 => array(
                    "lbl" => "Oui",
                    "nb_point" => 1
                ),
                2 => array(
                    "lbl" => "Non",
                    "nb_point" => 0
                )
            ),
            14 => array(
                "questionLbl" => "Le stagiaire s’est-il intéressé à l’entreprise ?",
                1 => array(
                    "lbl" => "Oui",
                    "nb_point" => 1
                ),
                2 => array(
                    "lbl" => "Non",
                    "nb_point" => 0
                )
            ),
        );
        try{
            return Answer::set_survey($survey,'Questionnaire Initiale',1) && Answer::set_able_survey_id(1);
        }catch (\Exception $e){
            throw $e;
        }

    }

    /**
     * Test la connexion à la BDD
     * @param string $host
     * @param string $dbname
     * @param string $user
     * @param string $password
     * @param bool $return_PDO_object
     * @return bool
     * @throws \Exception
     */
    static public function PDO_connect($host,$dbname,$user,$password,$return_PDO_object = false){

        $dsn = 'mysql:dbname='.$dbname.';host='.$host;
        try {
            $PDO = new \PDO($dsn, $user, $password);
        } catch (\PDOException $e) {
            switch($e->getCode()){
                case 1045 :
                    throw new \Exception("Connexion échouée : Accées non autorisé pour l'utilisateur \"$user\"",$e->getCode());
                    break;
                case 1049 :
                    throw new \Exception('Connexion échouée : Base de données iconnue',$e->getCode());
                    break;
                case 2005 :
                    throw new \Exception('Connexion échouée : Hôte iconnue',$e->getCode());
                    break;
            }
            throw new \Exception('Connexion échouée : ' . $e->getMessage(),$e->getCode());
        }
        if($return_PDO_object)
            return $PDO;
        return true;
    }

    /**
     * Crée le fichier de configuration de la BDD
     * @param string $host
     * @param string $dbname
     * @param string $user
     * @param string $password
     * @param string $prefix
     * @return bool
     * @throws \Exception
     */
    static public function create_db_datas_file($host,$dbname,$user,$password,$prefix){
        $datas = array(
            'host' => $host,
            'login' => $user,
            'password' => $password,
            'db_name' => $dbname,
            'prefix' => $prefix
        );
        if(!file_put_contents(ROOT.self::$db_datas_path,json_encode($datas)))
            throw new \Exception('Erreur lors de la configuation de l\'application',2);
        return true;
    }

} 