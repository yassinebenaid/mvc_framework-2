<?php

namespace Spoot\Provider;

use Spoot\Application;
use Spoot\Validation\Manager;
use Spoot\Validation\Rule\EmailRule;
use Spoot\Validation\Rule\MinRule;
use Spoot\Validation\Rule\RequiredRule;

class ValidationProvider
{
    public function bind(Application $app)
    {
        $app->bind("validate", function () use ($app) {
            $manager = new Manager();

            $manager->addRule("required", new RequiredRule());
            $manager->addRule("email", new EmailRule());
            $manager->addRule("min", new MinRule());

            return $manager;
        });
    }
}
