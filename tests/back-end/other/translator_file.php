<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 07/12/16
 * Time: 22:07
 */

include "../../../private/config.php";

$transition_language = "ru_RU";

$datas = link_parameters('languages/fr_FR');

$response = array();

translate_datas($datas,$response,$transition_language);
$json_datas = json_encode($response);
$replace = [' \\/ ','\\/ ','\\/'];
$json_datas = str_replace($replace,'/',$json_datas);

echo '<pre>';
var_dump($response);

file_put_contents('../../../private/parameters/languages/'.$transition_language.'.json',$json_datas);




function translate_datas($arrayToTranslate, &$response, $language,$except = null){

    is_null($except) && $except = ["icon","fname","email","phone","linkedin"];
    $language_error = [
        [
            "To send",
            "{Percent_response}",
            "Percent_response {}",
            "{} app_html_link",
            "{} Name_user",
            "Name_user {}",
            "Name_publisher {}"
        ],
        [
            "Send",
            "{percent_response}",
            "{percent_response}",
            "{app_html_link}",
            "{name_user}",
            "{name_user}",
            "{name_publisher}"
        ]
    ];

    foreach($arrayToTranslate as $key=>$row){
        if(is_array($row)){
            $currentExcept = $except;
            $key == "persons" && $currentExcept[] = "name";
            translate_datas($row,$response[$key],$language,$currentExcept);
        }else{
            $response[$key] = in_array($key,$except) ? $row : str_replace($language_error[0],$language_error[1],\general\Language::translate_text($row,'fr_FR',$language));
        }
    }
}