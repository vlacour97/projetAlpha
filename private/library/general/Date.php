<?php
/**
 * Created by PhpStorm.
 * User: remi
 * Date: 21/10/2016
 * Time: 16:14
 */

namespace general;


class Date
{
    private $datetime;
    private $week;
    private $cutWeek;
    private $month;
    private $cutMonth;
    private $connector;

    //CONSTRUCTEUR

    /**
     * @param string $date Date à instancier
     * @param array $lang Les textes de langues
     */
    function __construct($date, $lang="fr_FR")
    {
        require_once $_SERVER['DOCUMENT_ROOT'].'/private/config.php';

        $lang_array = link_parameters('languages/'.$lang)["general"]["date"]; //création d'un tableau contenant les chaînes de caractères
        //création de variables inclues dans le tableau
        $this->week = $lang_array['week'];
        $this->cutWeek = $lang_array['cut_week'];
        $this->month = $lang_array['month'];
        $this->cutMonth = $lang_array['cut_month'];
        $this->connector = $lang_array['connector'];
        $this->datetime = new \DateTime($date);

    }

    //METHODES

    /**
     * Mets à jour la date
     * @param string $date Date sur laquelle la date doit être mis à jour
     */
    function update($date)
    {
        $this->datetime = new \DateTime($date);
    }

    /**
     * Permet l'addition de date
     * @param string $duration chaine de caractére définissant la durée à ajouter
     */
    function add($duration)
    {
        $this->datetime->add(new \DateInterval($duration));
    }

    /**
     * Permet la soustraction de date
     * @param string $duration chaine de caractére définissant la durée à soustraire
     */
    function sub($duration)
    {
        $this->datetime->sub(new \DateInterval($duration));
    }

    /**
     * Donne la différence entre deux dates
     * @param string $date Date avec laquelle on doit faire la différence
     * @return bool|\DateInterval Intervalle de temps entre les deux dates
     */
    function diff($date){
        if($date instanceof Date)
            return $this->datetime->diff($date->datetime);
        if(is_string($date))
            return $this->datetime->diff(new \DateTime($date));
        return false;
    }

    /**
     * Affiche la date sous forme de chaine de caractére
     * @param string $date Format de la date
     * @return mixed|string La date au format voulu
     */
    function format($date = "yyyy-mm-dd hh:mn:ss")
    {
        //On récupére le nom des mois et des jours
        $response = $date;
        $week = $this->week[$this->datetime->format('N')-1];
        $cutWeek = $this->cutWeek[$this->datetime->format('N')-1];
        $month = $this->month[$this->datetime->format('n')-1];
        $cutMonth = $this->cutMonth[$this->datetime->format('n')-1];

        //On récupere l'heure selon le format (AM ou non)
        if(stripos($response,'P') === FALSE)
        {
            $hh = $this->datetime->format('H');
            $h = $this->datetime->format('G');
        }else{
            $hh = $this->datetime->format('h');
            $h = $this->datetime->format('g');
        }

        //On echange les valeur si elles sont supprimables
        $response = $this->deletable_data($response);

        //On replace les occurences du style yyyy,dd,m,s,... par leur valeur
        $replace = array(
            "search" => array('yyyy', 'yy', 'dd', 'd', 'mm','MM', 'hh', 'mn', 'ss', 'WW', 'W', '{a}','{h}','{min}','{s}', '[P]', '[p]','m', 'M', 'w', 'h'),
            "keyword" => array('{p1}','{p2}','{p3}','{p4}','{p5}','{p6}','{p7}','{p8}','{p9}','{p10}','{p11}','{p12}','{p13}','{p14}','{p15}','{p16}','{p17}','{p18}','{p19}','{p20}','{p21}', '{p22}'),
            "replace" => array(
                $this->datetime->format('Y'),
                $this->datetime->format('y'),
                $this->datetime->format('d'),
                $this->datetime->format('j'),
                $this->datetime->format('m'),
                $month,
                $hh,
                $this->datetime->format('i'),
                $this->datetime->format('s'),
                $week,
                $cutWeek,
                $this->connector["at"],
                $this->connector["h"],
                $this->connector["min"],
                $this->connector["s"],
                $this->datetime->format('A'),
                $this->datetime->format('a'),
                $this->datetime->format('n'),
                $cutMonth,
                $this->datetime->format('N'),
                $h
            )

        );
        $response = str_replace($replace['search'],$replace['keyword'],$response);
        $response = str_replace($replace['keyword'],$replace['replace'],$response);

        //On retourne la réponse
        return $response;
    }

    /**
     * Supprime par exemple un heure si elle est égale à 0, si la syntaxe le demande
     * @param string $model Le modele à modifier
     * @return string Le modele modifier
     */
    private function deletable_data($model){
        $response = $model;

        if(strpos($model,'%hh%') !== false)
            if($this->datetime->format('H') != "00")
                $response = str_replace('%hh%','hh',$response);
            else
                $response = str_replace(['%hh%','{h}'],'',$response);

        if(strpos($model,'%h%') !== false)
            if($this->datetime->format('H') != "00")
                $response = str_replace('%h%','h',$response);
            else
                $response = str_replace(['%h%','{h}'],'',$response);
        if(strpos($model,'%mn%') !== false)
            if($this->datetime->format('i') != "00")
                $response = str_replace('%mn%','mn',$response);
            else
                $response = str_replace(['%mn%','{min}'],'',$response);

        if(strpos($model,'%ss%') !== false)
            if($this->datetime->format('s') != "00")
                $response = str_replace('%ss%','ss',$response);
            else
                $response = str_replace(['%ss%','{s}'],'',$response);

        return $response;
    }

    /**
     * Permettre l'affichage d'une durée dans toutes les langues et sur toutes formes
     * @param \DateInterval $interval Durée d'entrée
     * @param string $model Le modele de retour
     * @param array $lang Les textes de langues
     * @return string La durée en toutes lettres
     */
    static function DateInterval_Format($interval,$lang="fr_FR",$model = "%y {y} %m {m} %d {d} %h {h} %i {min} %s {s}"){

        require_once $_SERVER['DOCUMENT_ROOT'].'/private/config.php';

        $lang_array = link_parameters('languages/'.$lang)['general']['date'];
        $text = $lang_array['connector'];

        if(strpos($model,'{y}') !== false && $interval->y != 0)
            if($interval->y == 1)
                $model = str_replace('{y}',$text['y_s'],$model);
            else
                $model = str_replace('{y}',$text['y_p'],$model);
        else
            $model = str_replace(['%Y','%y','{y}'],'',$model);

        if(strpos($model,'{m}') !== false && $interval->d != 0)
            if($interval->y == 1)
                $model = str_replace('{m}',$text['m_s'],$model);
            else
                $model = str_replace('{m}',$text['m_p'],$model);
        else
            $model = str_replace(['%M','%m','{m}'],'',$model);

        if(strpos($model,'{d}') !== false && $interval->d != 0)
            if($interval->y == 1)
                $model = str_replace('{d}',$text['d_s'],$model);
            else
                $model = str_replace('{d}',$text['d_p'],$model);
        else
            $model = str_replace(['%D','%d','{d}'],'',$model);

        if(strpos($model,'{h}') !== false && $interval->h != 0)
            if($interval->y == 1)
                $model = str_replace('{h}',$text['h_s'],$model);
            else
                $model = str_replace('{h}',$text['h_p'],$model);
        else
            $model = str_replace(['%H','%h','{h}'],'',$model);

        if(strpos($model,'{min}') !== false && $interval->i != 0)
            if($interval->y == 1)
                $model = str_replace('{min}',$text['min_s'],$model);
            else
                $model = str_replace('{min}',$text['min_p'],$model);
        else
            $model = str_replace(['%I','%i','{min}'],'',$model);

        if(strpos($model,'{s}') !== false && $interval->s != 0)
            if($interval->y == 1)
                $model = str_replace('{s}',$text['s_s'],$model);
            else
                $model = str_replace('{s}',$text['s_p'],$model);
        else
            $model = str_replace(['%S','%s','{s}'],'',$model);

        return $interval->format($model);

    }
}