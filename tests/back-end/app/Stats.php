<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 19/11/16
 * Time: 15:15
 */

include_once '../../../private/config.php';

echo '<pre>';

//var_dump(\app\Stats::count_connections());
//var_dump(\app\Stats::evolution_of_connections_by_day());
//var_dump(\app\Stats::count_connections_by_countries());
//var_dump(\app\Stats::globalResponsesState());
//var_dump(\app\Stats::userResponsesState(9));
//var_dump(\app\Stats::progressResponsesState(47));


$var = \app\Stats::evolution_of_connections_by_day();

foreach($var as $content){
    /** @var $content \app\ConnectionsDayDatas */
    echo $content->day->format('d MM yyyy').' - '.$content->nbConnections.'<br>';
}