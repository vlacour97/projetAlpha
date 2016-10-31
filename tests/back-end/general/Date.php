<?php
/**
 * Created by PhpStorm.
 * User: remi
 * Date: 21/10/2016
 * Time: 16:19
 */

include_once '../../../private/config.php';

$date1 = new \general\Date("2016-10-21 12:12:12",'');
$date2 = new \general\Date("now");
$date3 = new \general\Date("2016-01-01 14:00:50");

echo $date1->format("WW d M yyyy")."<br>";
echo $date2->format()."<br>";

$date1->update("2016-02-09 12:12:12");
echo $date1->format()."<br>";
echo $date2->format("%hh%{h} %mn%{min} %ss%{s}")."<br>";
echo $date3->format("%hh%{h} %mn%{min} %ss%{s}")."<br>"; //quand zéro -> affiche pas
$diff =  $date1->diff($date3);
echo \general\Date::DateInterval_Format($diff, "fr_FR", "%y{y} %m{m} %d{d} %h{h}, %i{min} %s{s}")."<br>"; // problème : n'affiche pas "mois"








