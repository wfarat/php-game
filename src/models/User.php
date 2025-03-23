<?php

namespace App\models;

class User
{
    public int $id {
        get {
            return $this->id;
        }
        set {
            $this->id = $value;
        }
    }
    public string $login {
        get {
            return $this->login;
        }
        set {
            $this->login = trim($value);
        }
    }
    public string $password {
        set {
            $info = password_get_info($value);
            if ($info['algo'] === 0) {
                $this->hashedPassword = password_hash($value, PASSWORD_DEFAULT);
            } else {
                $this->hashedPassword = $value;
            }
        }
    }
    public string $email {
        get {
            return $this->email;
        }
        set {
            $this->email = trim($value);
        }
    }
    public string $hashedPassword;
    public string $role;
    public bool $verified;
    function __construct($login, $password, $email)
    {
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
    }

}
