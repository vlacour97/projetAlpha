<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 15/11/16
 * Time: 21:32
 */

include_once '../../../private/config.php';

echo '<pre>';

//var_dump(\general\PDOQueries::search_students('Demor'));
//var_dump(\general\PDOQueries::search_students_of_TI('',9));
//var_dump(\general\PDOQueries::search_students_of_TE('demory',45));
//var_dump(\general\PDOQueries::search_users('la'));
//var_dump(\general\PDOQueries::search_users_from_TE('demory',45));
//var_dump(\general\PDOQueries::search_messages('equitis'));

/*
try{
    var_dump(\app\Search::searching_students(''));
}catch (Exception $e){
    echo $e->getMessage();
}*/

/*
try{
    var_dump(\app\Search::searching_users('la'));
}catch (Exception $e){
    echo $e->getMessage();
}*/

/*
try{
    var_dump(\app\Search::searching_posts('lut'));
}catch (Exception $e){
    echo $e->getMessage();
}*/

/*
try{
    var_dump(\app\Search::searching_messages('equitis'));
}catch (Exception $e){
    echo $e->getMessage();
}*/


$datas = \app\Search::searching_students('Lema');
foreach ($datas as $student) {
    /** @var $student app\StudentDatas */
    echo $student->fname.' '.$student->name.'<br>';
}

$datas2 = \app\Search::searching_users('lacour');
foreach ($datas2 as $user) {
    /** @var $student app\UserDatas */
    echo $user->fname.' '.$user->name.'<br>';
}

$datas3 = \app\Search::searching_posts('lut');
foreach ($datas3 as $post) {
    /** @var $post app\TimelineDatas */
    echo $post->content.' '.$post->publication_date->format('dd MM yyyy').'<br>';
}

$datas4 = \app\Search::searching_messages('equitis');
foreach ($datas4 as $post) {
    /** @var $post app\MessageDatas */
    echo $post->object.' '.$post->content.' - '.$post->recipient_name.'<br>';
}