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
    public $int = [];
    /**
     * @var array
     */
    public $dates = [];
    /**
     * @var array
     */
    public $bool = [];
    /**
     * @var array
     */
    public $useless_attr = [];
    /**
     * @var array
     */
    public $useless_add_attr = [];

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
}