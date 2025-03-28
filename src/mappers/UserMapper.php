<?php

namespace App\mappers;

use App\models\User;

class UserMapper
{
    // This method maps the database result to a User object
    public static function mapToUser(array $userData): User
    {
        $user = new User(
            $userData['login'],   // login
            $userData['password'],// password
            $userData['email']// email
        );

        $user->id = $userData['id'];  // Set the user ID
        $user->verified = $userData['verified'];
        return $user;
    }
}
