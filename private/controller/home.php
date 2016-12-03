<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 25/11/16
 * Time: 10:46
 */

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    include "../config.php";

    switch($_GET['action']){
        case 'countries' :
            try{
                $countries_datas = \app\Stats::count_connections_by_countries();
                $max = 0;
                foreach($countries_datas as $country)
                    /** @var $country \app\ConnectionsCountriesDatas */
                    $max += $country->nbConnections;

                $response = array(
                    'map' => array(
                        'name' => 'world_countries'
                    ),
                    'defaultPlot' => array(
                        'attrs' => array(
                            'fill' => '#fff',
                            'opacity' => 0.6
                        )
                    )
                );
                foreach($countries_datas as $country){
                    /** @var $country \app\ConnectionsCountriesDatas */
                    $response['plots'][] = array(
                        'type' => 'circle',
                        'size' => round($country->nbConnections/$max * 100),
                        'latitude' => $country->lat,
                        'longitude' => $country->long,
                        'attrs' => array(
                            'opacity' => 0.7,
                            'fill' => '#888'
                        ),
                        'attrsHover' => array(
                            'transform' => 's1.5'
                        )
                    );
                }
                    echo json_encode(array('response'=>true,'exception'=>null,'code' => null,'content' => $response));
            }catch (Exception $e){
                echo json_encode(array('response'=>false,'exception'=>$e->getMessage(),'code' => $e->getCode()));
            }
            break;
        case 'lineStats' :
            try{
                $connections = \app\Stats::evolution_of_connections_by_day();
                $response = array();
                foreach($connections as $connection)
                    /** @var $connection \app\ConnectionsDayDatas */
                    $response[] = array('d'=>$connection->day->format('yyyy-mm-dd'),'y'=>$connection->nbConnections);

                echo json_encode(array('response'=>true,'exception'=>null,'code' => null,'content' => $response));
            }catch (Exception $e){
                echo json_encode(array('response'=>false,'exception'=>$e->getMessage(),'code' => $e->getCode()));
            }
            break;

    }


    die();
}

$html = new \general\HTML();

$script_vendor = array(
    'bootstrap-sass/vendor/assets/javascripts/bootstrap/tooltip.js',
    'bootstrap3-wysihtml5/src/bootstrap3-wysihtml5.js',
    'underscore/underscore-min.js',
    'backbone/backbone.js',
    'tinymce/tinymce.min.js',
    'jasny-bootstrap/js/fileinput.js',
    'skycons/skycons.js',
    'raphael/raphael-min.js',
    'jQuery-Mapael/js/jquery.mapael.js',
    'jQuery-Mapael/js/maps/world_countries.js',
    'jQuery-Mapael/js/maps/france_departments.js',
    'jquery-animateNumber/jquery.animateNumber.min.js',
    'morris.js/morris.min.js'
);
$script = array('dashboard.js');

$type = \app\Log::get_type();

switch($type){
    case 1:
        $responses = \app\Stats::globalResponsesState();
        $gabarit = \general\Language::translate_gabarit('pages/dashboard/admin_dashboard');
        $replace = array('{nb_connections}','{responses_empty}','{responses_finish}','{responses_validate}','{weather_widget}','{message_widget}');
        $by = array(\app\Stats::count_connections(),$responses->count_not_respond,$responses->count_respond,$responses->count_valided,$html->widget()->weather(),$html->widget()->message());
        $gabarit = str_replace($replace,$by,$gabarit);
        break;
    default:
        $responses = \app\Stats::userResponsesState(\app\Log::get_id());
        $gabarit = \general\Language::translate_gabarit('pages/dashboard/other_dashboard');
        $replace = array('{responses_empty}','{responses_finish}','{responses_validate}','{weather_widget}','{message_widget}');
        $by = array($responses->count_not_respond,$responses->count_respond,$responses->count_valided,$html->widget()->weather(),$html->widget()->message());
        $gabarit = str_replace($replace,$by,$gabarit);
        break;
}


$html->open();
$html->sidebar();
$html->navbar();
echo $gabarit;
$html->close($script_vendor,$script);
