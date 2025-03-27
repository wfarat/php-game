<?php

namespace App\controllers;

use App\exceptions\UserNotFoundException;
use App\services\UserService;
use PDOException;use Random\RandomException;
use SendGrid;
use SendGrid\Mail\Mail;

class UserController {
    private UserService $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    /**
     * @throws RandomException
     */
    public function register(): void
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $login = $_POST['login'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $repeat = $_POST['repeat'] ?? '';
            $token = bin2hex(random_bytes(32)); // Generate a secure token

            if ($password !== $repeat) {
                echo "Passwords don't match!";
                return;
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Invalid email format!";
                return;
            }
            if (!empty($login) && !empty($email) && !empty($password)) {
                try {
                    $this->userService->createUser($login, $email, $password, $token);
                } catch (PDOException $e) {
                    echo $e->getMessage();
                    return;
                }
                $this->sendVerificationEmail($email, $login, $token);
                echo "User registered successfully!";
            } else {
                echo "Please fill in all fields.";
            }
        }
    }

    public function login(): void
    {
         if ($_SERVER["REQUEST_METHOD"] === "POST") {
             $login = $_POST['login'] ?? '';
             $password = $_POST['password'] ?? '';
         if (!empty($login) && !empty($password)) {
             try {
                $auth = $this->userService->login($login, $password);
                if (!$auth->isAuthenticated) {
                    echo "Invalid login or password!";
                } else {
                    $_SESSION['user'] = $auth->user;
                    $_SESSION['auth'] = true;
                    session_write_close();
                    header("Location: game/index.php");
                }
             } catch (UserNotFoundException $e) {
                 echo "Invalid login or password!";
             }
         }
         }
    }
    public function verify(): void
    {
        if (isset($_GET['token'])) {
            $token = $_GET['token'];
            $res = $this->userService->verifyUser($token);
            if ($res) {
                echo "Email verified successfully!";
            } else {
                echo "Invalid token!";
            }
        }
    }
    function sendVerificationEmail($target, $login, $token): void
    {
        $verifyLink = "https://php-game-container.icygrass-03b1dca3.polandcentral.azurecontainerapps.io/public/verify.php?token=" . $token;
        $email = new Mail();
        $email->setFrom("wfarat@gmail.com", "Admin");
        $email->setSubject("Email Verification");
        $email->addTo($target, $login);
        $email->addContent(
            "text/html", "Click this link to verify your email: <a href='$verifyLink'>$verifyLink</a>"
        );
        $sendgrid = new SendGrid(getenv('SENDGRID_API_KEY'));
        try {
            $response = $sendgrid->send($email);
            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }
}

