<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 29/10/16
 * Time: 20:10
 */

include_once '../../../private/config.php';


//\app\Config::create_config_file('Test','des','key','auth','mail','deadl');

echo \app\Config::getAdminMail().'<br>';
echo \app\Config::getCurrentSurvey().'<br>';
echo \app\Config::getDeadlineDate().'<br>';
//\app\Config::setAdminMail('vlacour97@icloud.com');