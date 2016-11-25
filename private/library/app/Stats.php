<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 19/11/16
 * Time: 15:03
 */

namespace app;

use general\Date;
use general\PDOQueries;

/**
 * Class ConnectionsDayDatas
 * @package app
 * @author Valentin Lacour
 */
class ConnectionsDayDatas extends ReturnDatas{
    /**
     * @var int
     */
    public $nbConnections;
    /**
     * @var \general\Date
     */
    public $day;
    /**
     * @var array
     */
    protected $int = ['nbConnections'];
    /**
     * @var array
     */
    protected $dates = ['day'];
}

/**
 * Class ResponsesDatas
 * @package app
 * @author Valentin Lacour
 */
class ResponsesDatas extends ReturnDatas{
    /**
     * @var int
     */
    public $count_not_respond;
    /**
     * @var int
     */
    public $count_respond;
    /**
     * @var int
     */
    public $count_valided;
    /**
     * @var array
     */
    protected $int = ['count_not_respond','count_respond','count_valided'];
}

/**
 * Class ConnectionsCountriesDatas
 * @package app
 * @author Valentin Lacour
 */
class ConnectionsCountriesDatas extends ReturnDatas{
    /**
     * @var int
     */
    public $nbConnections;
    /**
     * @var string
     */
    public $country;
    /**
     * @var float
     */
    public $lat;
    /**
     * @var float
     */
    public $long;
    /**
     * @var array
     */
    protected $int = ['nbConnections','lat','long'];
}

/**
 * Class Stats
 * @package app
 * @author Valentin Lacour
 */
class Stats {

    /**
     * @var int Nombre de jour pour l'affichage du nombre de connexions
     */
    static private $nb_of_day = 7;

    /**
     * Récupere le nombre de connexions sur l'app
     * @return int
     */
    static function count_connections(){
        return PDOQueries::count_stats();
    }

    /**
     * Récupere le nombre de connexions par jour
     * @return array
     */
    static function evolution_of_connections_by_day(){
        $datas = PDOQueries::count_stats_by_day(self::$nb_of_day);
        $response = [];
        $datas_iterator = 0;
        $max_datas_iterator = count($datas)-1;

        for ($i = 0; $i < self::$nb_of_day; $i++)
        {
            $tmp_date = new Date('now');
            $tmp_date->sub('P'.($i+1).'D');
            $tmp_db_date = new Date($datas[$datas_iterator]['day']);


            if($tmp_date->format('dd-mm-yyyy') == $tmp_db_date->format('dd-mm-yyyy')){
                ReturnDatas::format_datas($datas[$datas_iterator],$response[] = new ConnectionsDayDatas());
                if($datas_iterator < $max_datas_iterator)
                    $datas_iterator++;
            }else{
                $tmp_object = new ConnectionsDayDatas();
                $tmp_object->day = $tmp_date;
                $tmp_object->nbConnections = 0;
                $response[] = $tmp_object;
            }

        }
        return $response;
    }

    /**
     * Compte le nombre de connexions par pays
     * @return array
     */
    static function count_connections_by_countries(){
        $datas = PDOQueries::count_stats_by_country();
        $localisations = link_parameters('general/localisations');
        $response = [];
        foreach($datas as $counter){
            $id_pays = $counter['country'];
            $infos_country = $localisations[$id_pays];
            $counter['lat'] = $infos_country['lat'];
            $counter['long'] = $infos_country['long'];
            ReturnDatas::format_datas($counter,$response[] = new ConnectionsCountriesDatas());
        }
        return $response;
    }

    /**
     * Recupére les stats sur tout les questionnaires
     * @return ResponsesDatas
     */
    static function globalResponsesState(){
        $datas = PDOQueries::count_responses_for_admin();
        $response = new ResponsesDatas();
        ReturnDatas::format_datas($datas,$response);
        return $response;
    }

    /**
     * Récupére les stats sur les questionnaires d'un utilisateur
     * @param $id_user
     * @return ResponsesDatas
     */
    static function userResponsesState($id_user){
        $datas = PDOQueries::count_responses_for_users($id_user);
        $response = new ResponsesDatas();
        ReturnDatas::format_datas($datas,$response);
        return $response;
    }

    static function progressResponsesState($id_user){
        if(PDOQueries::isTI($id_user) || PDOQueries::isTE($id_user))
            $datas = self::userResponsesState($id_user);
        else
            $datas = self::globalResponsesState($id_user);
        $not_answered = $datas->count_not_respond;
        $total = $datas->count_respond + $datas->count_not_respond + $datas->count_valided;
        return  round((1 - ($not_answered/$total)) * 100);
    }

} 