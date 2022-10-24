<?php

use Symfony\Component\Console\Application;

require_once __DIR__ . "/vendor/autoload.php";

$app = new Application();
$commands = require __DIR__ . "./app/commands.php";

foreach ($commands as $command) {
    $app->add($command);
}

$app->run();
