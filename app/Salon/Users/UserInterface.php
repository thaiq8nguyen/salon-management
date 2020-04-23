<?php
namespace App\Salon\Users;

interface UserInterface
{
    public function login($credential);

    public function logout();

    public function register($user);


}
