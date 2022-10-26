 <?php

// use PHPUnit\Framework\TestCase;
// use Spoot\Validation\Manager;
// use Spoot\Validation\Rule\EmailRule;
// use Spoot\Validation\ValidationException;

// // tests use framework classes...
// require __DIR__ . '/../vendor/autoload.php';
// // validation manager uses $_SESSION...
// session_start();



// class ValidationTest extends TestCase
// {
//     protected Manager $manager;

//     public function testInvalidEmailValuesFail()
//     {
//         $this->manager = new Manager();
//         $this->manager->addRule('email', new EmailRule());

//         $expected = ['email' => ['email should be an email']];
//         [$exception] = $this->assertExc
//         throw new Exception('validation did not fail');
//     }

//     public function testValidEmailValuesPass()
//     {
//         $this->manager = new Manager();
//         $this->manager->addRule('email', new EmailRule());

//         try {
//             $this->manager->validate(
//                 ['email' => 'foo@bar.com'],
//                 ['email' => ['email']]
//             );
//         } catch (Throwable $e) {
//             throw new Exception('validation did failed');
//             return;
//         }
//     }
// }
