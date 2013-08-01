<?php

use Knp\Provider\ConsoleServiceProvider;
use Keelerm\Commands\FetchSkills;

$app = require_once __DIR__ . '/bootstrap.php';

$application = $app['console'];

$application->add(new FetchSkills());
$application->run();

