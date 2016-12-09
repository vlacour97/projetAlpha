<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 05/11/16
 * Time: 22:15
 */

include_once '../../../private/config.php';

$csv = new other\parseCSV('test.csv');
print_r($csv->data);