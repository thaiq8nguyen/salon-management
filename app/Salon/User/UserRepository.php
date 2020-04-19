<?php
namespace App\Salon\User;

use App\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class UserRepository implements UserInterface
{
    public function login($credential)
    {
        error_log('login');
        if(Auth::attempt(['email' => $credential['email'], 'password' => $credential['password']]))
        {
            $user = Auth::user();



            $token = $user->createToken('access');

            $result = [
                'accessToken' => $token->accessToken,
                'expiration' => Carbon::parse($token->token->expires_at)->toDateTimeString(),
                'useFullName' => $user->name,

            ];

            return $result;

        }

        return false;
    }

    public function logout()
    {}
    public function register($user)
    {}

}
