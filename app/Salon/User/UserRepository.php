<?php

namespace App\Salon\User;

use App\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class UserRepository implements UserInterface
{
    public function login($credential)
    {

        if (Auth::attempt(['email' => $credential['email'], 'password' => $credential['password']])) {
            $user = Auth::user();


            $token = $user->createToken('access');

            $result = [
                'accessToken' => $token->accessToken,
                'expiredAt' => Carbon::parse($token->token->expires_at)->toDateTimeString(),
                'name' => $user->name,

            ];

            return $result;

        }

        return false;
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::user()->token()->revoke();
            return true;
        }
        return false;

    }

    public function register($user)
    {
        $user = User::create([
            'name' => $user['firstName'] . ' ' . $user['lastName'],
            'email' => $user['email'],
            'password' => bcrypt($user['password'])
        ]);

        return $user;
    }


}
