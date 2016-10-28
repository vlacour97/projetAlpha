<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 22/10/16
 * Time: 10:22
 */

include_once '../../../private/config.php';

\general\PDOQueries::init();

//var_dump(\general\PDOQueries::show_all_students());
//var_dump(\general\PDOQueries::show_all_users());

echo '<table>';
foreach(\general\PDOQueries::show_all_users() as $content){
    echo '<tr>';
    echo '<td>'.$content['fname'].' '.$content['name'].'</td>';
    echo '</tr>';
}
echo '</table>';

var_dump(\general\PDOQueries::initialize('2016-10-22 14:01:30'));


var_dump(\general\PDOQueries::like_post(6,7));

var_dump(\general\PDOQueries::get_max_post_id());