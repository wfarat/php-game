<?php

namespace App\controllers;

use App\exceptions\UserNotFoundException;
use App\services\UserService;
use PDOException;use Random\RandomException;

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
                $this->sendVerificationEmail($email, $token);
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
    function sendVerificationEmail($email, $token): void
    {
        $verifyLink = "https://yourwebsite.com/verify.php?token=" . $token;
        $subject = "Email Verification";
        $message = "Click this link to verify your email: <a href='$verifyLink'>$verifyLink</a>";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: no-reply@yourwebsite.com" . "\r\n";

        mail($email, $subject, $message, $headers);
    }
}

