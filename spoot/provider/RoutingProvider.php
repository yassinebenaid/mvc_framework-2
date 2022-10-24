<?php

namespace Spoot\Provider;

use Spoot\Application;
use Spoot\Routing\Router;

class RoutingProvider
{
    public function bind(Application $app)
    {
        $app->bind(Router::class, fn () => new Router);
    }
}
