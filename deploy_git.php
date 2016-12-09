<?php

require 'private/library/other/Deploy.php';

if(!Deploy::run())
    die('Erreur');

