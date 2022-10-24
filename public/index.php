<?php

use Spoot\Application;

require_once dirname(__DIR__) . "/vendor/autoload.php";


$app = Application::GetInstance();

$app->bind("path.base", fn () => dirname(__DIR__));

$app->run();
