<?php

namespace App\mappers;

use App\models\AttackableUser;
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
        $user->role = $userData['role'] ?? '';
        $user->banned = $userData['banned'] ?? false;
        return $user;
    }

    public static function mapToAttackableUser(array $userData): AttackableUser
    {
        return new AttackableUser(
            $userData['login'],
            $userData['id'],
            $userData['battles_won']
        );
    }
}
