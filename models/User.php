<?php
class User
{
    public $id;
    public $email;
    public $password;
    public $name;
    public $birthdate;
    public $city;
    public $work;
    public $avatar;
    public $cover;
    public $token;
}

interface UserDAO
{
    public function findByToken(String $token);
    public function findByEmail(String $email);
    public function update(User $user);
}