<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 19/11/16
 * Time: 13:15
 */

include_once '../../../private/config.php';

echo '<pre>';

$weather = new \app\Weather('Amiens','80000');

$datas = $weather->getWeather();

echo "Meteo pour : ".$datas->city.','.$datas->country.'<br>';
echo "Aujourd'hui : ".$datas->today->temp.' - '.$datas->today->lbl.'<br>';
foreach($datas->days as $day){
    /** @var $day \app\WeatherDayDatas */
    echo $day->date->format('d M').' : '.$day->temp.' - '.$day->lbl.'<br>';
}