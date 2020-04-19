<?php
namespace App\Salon\User;

interface UserInterface
{
    public function login($credential);

    public function logout();

    public function register($user);

    
}