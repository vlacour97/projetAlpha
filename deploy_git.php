<?php

$remote = "origin";
$branch = "Valentin";

exec('git pull');
exec("git checkout {$remote}/{$branch}");