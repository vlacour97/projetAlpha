<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 07/12/16
 * Time: 22:07
 */

include "../../../private/config.php";

$datas = link_parameters('languages/fr_FR');

$response = array();

translate_datas($datas,$response);

echo '<pre>';
var_dump($response);

file_put_contents('../../../private/parameters/languages/en_EN.json',json_encode($response));




function translate_datas($arrayToTranslate, &$response){

    foreach($arrayToTranslate as $key=>$row){
        if(is_array($row)){
            translate_datas($row,$response[$key]);
        }else{
            $response[$key] = \general\Language::translate_text($row,'fr_FR','en_EN');
        }
    }
}