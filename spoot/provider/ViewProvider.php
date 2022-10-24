<?php

namespace Spoot\Provider;

use Spoot\Application;
use Spoot\View\Engine\SpootEngine;
use Spoot\View\Manager;

class ViewProvider
{
    public function bind(Application $app)
    {
        $app->bind("view", function () use ($app) {
            $manager = new Manager;

            $this->bindPaths($app, $manager);
            $this->bindEngines($app, $manager);
            $this->bindMacros($manager);

            return $manager;
        });
    }

    private function bindPaths(Application $app, Manager $manager): void
    {
        $manager->addPath($app->resolve("path.base") . "/views");
    }

    private function bindEngines(Application $app, Manager $manager): void
    {
        $app->bind("view.engine.spoot", fn () =>  new SpootEngine);

        $manager->addEngine("spoot.html", $app->resolve("view.engine.spoot"));
    }

    private function bindMacros(Manager $manager): void
    {
        $manager->addMacro("escape", fn ($value) => htmlspecialchars($value, ENT_QUOTES));
        $manager->addMacro("include", fn (string $page, array $data = []) => view($page, $data));
    }
}
