<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 28/11/16
 * Time: 23:39
 */

$id = \general\crypt::decrypt($_GET['id']);

if(!\general\PDOQueries::isset_student($id))
    header('Location: index.php');

\app\Answer::generateSurveyPDF($id);