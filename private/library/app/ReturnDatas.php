<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 19/11/16
 * Time: 12:22
 */

namespace app;


/**
 * Class ReturnDatas
 * @package app
 * @author Valentin Lacour
 */
Class ReturnDatas{
    /**
     * @var array
     */
    protected $int = [];
    /**
     * @var array
     */
    protected $dates = [];
    /**
     * @var array
     */
    protected $bool = [];
    /**
     * @var array
     */
    protected $useless_attr = [];
    /**
     * @var array
     */
    protected  $useless_add_attr = [];

    /**
     * Formattage de données
     * @param array $datas
     * @param ReturnDatas $object
     */
    static public function format_datas($datas,&$object){
        foreach ($datas as $key=>$content) {
            if(is_string($key) && !in_array($key,$object->useless_attr)){
                if(in_array($key,$object->int))
                    $object->$key=intval($content);
                elseif(in_array($key,$object->dates) && $content != '0000-00-00 00:00:00' && $content != '0000-00-00' && $content != null)
                    $object->$key=new \general\Date($content);
                elseif(in_array($key,$object->bool))
                    $object->$key=boolval($content);
                else
                    $object->$key=$content;
            }
        }
    }

    /**
     * Formate les données pour l'édition
     * @param array $datas
     * @param array $args
     * @param ReturnDatas $object
     */
    static function formate_datas_for_edit($datas,$args,&$object){
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
}