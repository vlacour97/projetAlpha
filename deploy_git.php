<?php

$remote = "origin";
$branch = "WebDeveloppement";

exec('git pull');
exec("git checkout {$remote}/{$branch}");