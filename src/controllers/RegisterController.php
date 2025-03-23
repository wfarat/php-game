<?php

namespace App\controllers;

use App\services\UserService;
use Random\RandomException;

class RegisterController {
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
            $token = bin2hex(random_bytes(32)); // Generate a secure token

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Invalid email format!";
                return;
            }
            if (!empty($login) && !empty($email) && !empty($password)) {
                $res = $this->userService->createUser($login, $email, $password, $token);
                if (!$res) {
                    echo "User already exists!";
                    return;
                }
                $this->sendVerificationEmail($email, $token);
                echo "User registered successfully!";
            } else {
                echo "Please fill in all fields.";
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
?>
