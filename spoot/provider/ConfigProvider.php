<?php

namespace Spoot\Provider;

use Spoot\Application;
use Spoot\Support\Config;

class ConfigProvider
{
    public function bind(Application $app)
    {
        $app->bind('config', fn () => new Config);
    }
}
