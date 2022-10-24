<?php
// tests use framework classes...

use Spoot\Validation\Manager;
use Spoot\Validation\Rule\EmailRule;
use Spoot\Validation\ValidationException;

require __DIR__ . '/../vendor/autoload.php';
// validation manager uses $_SESSION...
session_start();



class ValidationTest
{
    protected Manager $manager;

    public function setUp()
    {
        $this->manager = new Manager();
        $this->manager->addRule('email', new EmailRule());
    }

    public function testInvalidEmailValuesFail()
    {
        $this->setUp();
        $expected = ['email' => ['email should be an email']];

        try {
            $this->manager->validate(['email' => 'foo'], ['email' =>
            ['email']]);
        } catch (Throwable $e) {
            assert($e instanceof ValidationException, 'error should be thrown');
            assert(
                $e->getErrors()['email'] === $expected['email'],
                'messages should match'
            );
            return;
        }
        throw new Exception('validation did not fail');
    }

    public function testValidEmailValuesPass()
    {
        $this->setUp();
        try {
            $this->manager->validate(
                ['email' => 'foo@bar.com'],
                ['email' => ['email']]
            );
        } catch (Throwable $e) {
            throw new Exception('validation did failed');
            return;
        }
    }
}

$test = new ValidationTest();
$test->testInvalidEmailValuesFail();
$test->testValidEmailValuesPass();
print 'All tests passed' . PHP_EOL;
