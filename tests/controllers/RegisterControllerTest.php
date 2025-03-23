<?php

namespace Test\controllers;

use App\controllers\RegisterController;
use App\core\Database;
use App\services\UserService;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Random\RandomException;
use Test\TestDbConfig;

class RegisterControllerTest extends TestCase {
    /**
     * @throws Exception
     * @throws RandomException
     */
    public function testRegisterWithValidData() {
        $_SERVER["REQUEST_METHOD"] = "POST";
        $_POST['login'] = "Jane";
        $_POST['email'] = "jane@example.com";
        $_POST['password'] = "securepass";
        $mockService = $this->createMock(UserService::class);;
        $mockService->method('createUser')->willReturn(true);
        // Create a partial mock of RegisterController (mock sendVerificationEmail)
        $mockController = $this->getMockBuilder(RegisterController::class)
            ->setConstructorArgs([$mockService])
            ->onlyMethods(['sendVerificationEmail']) // This method will be mocked
            ->getMock();

        // Make sure sendVerificationEmail is NOT actually called
        $mockController->expects($this->once()) // Expecting this function to be called ONCE
        ->method('sendVerificationEmail')
            ->with($this->equalTo("jane@example.com"), $this->anything());
        ob_start();
        $mockController->register();
        $output = ob_get_clean();

        $this->assertStringContainsString("User registered successfully!", $output);
    }
}
?>
