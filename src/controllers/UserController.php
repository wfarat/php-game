<?php

namespace App\controllers;

use App\exceptions\UserNotFoundException;
use App\services\UserService;
use DateMalformedStringException;
use Exception;
use PDOException;
use Random\RandomException;
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
                    $_SESSION['auth'] = $auth->isAuthenticated;
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
            if ($response->statusCode() === 202) {
                echo 'Verification email sent to: ' . $target;
            }
        } catch (Exception $e) {
            echo 'There was a problem with sending verification email';
        }
    }

    public function sendRecoveryEmail($target, $login, $token): void
    {
        $verifyLink = "https://php-game-container.icygrass-03b1dca3.polandcentral.azurecontainerapps.io/public/recovery.php?token=" . $token;
        $email = new Mail();
        $email->setFrom("wfarat@gmail.com", "Admin");
        $email->setSubject("Password Recovery");
        $email->addTo($target, $login);
        $email->addContent(
            "text/html", "Click this link to recover your password: <a href='$verifyLink'>$verifyLink</a>"
        );
        $sendgrid = new SendGrid(getenv('SENDGRID_API_KEY'));
        try {
            $response = $sendgrid->send($email);
            if ($response->statusCode() === 202) {
                echo 'Password recovery email sent to: ' . $target;
            }
        } catch (Exception $e) {
            echo 'There was a problem with sending password recovery email';
        }
    }
    public function getUsers(): array
    {
        if (!isset($_SESSION['users'])) {
            $_SESSION['users'] = $this->userService->getUsers();
        }
        return $_SESSION['users'];
    }

    /**
     * @throws RandomException
     */
    public function recover(): void
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = $_POST['email'] ?? '';
        if (!empty($email)) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Invalid email format!";
                return;
            }
            $token = bin2hex(random_bytes(32)); // Generate a secure token
            try {
                $user = $this->userService->findUserByEmail($email);
                $this->userService->saveRecoveryToken($token, $user->id);
                $this->sendRecoveryEmail($email, $user->login, $token);
            } catch (PDOException|UserNotFoundException $e) {
                echo $e->getMessage();
                return;
            }
        }
        }
    }

    public function recoverPassword(): void
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $token = $_POST['token'] ?? '';
            $newPassword = $_POST['newPassword'] ?? '';
            if (!empty($token) && !empty($newPassword)) {
                try {
                    $success = $this->userService->recoverPassword($token, $newPassword);
                    if ($success) {
                        echo "Password changed successfully!";
                    } else {
                        echo "Invalid token!";
                    }
                } catch (PDOException|DateMalformedStringException $e) {
                    echo $e->getMessage();
                    return;
                }
            }
        }
    }
}

