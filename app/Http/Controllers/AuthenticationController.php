<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Salon\Users\UserInterface;
use Log;

class AuthenticationController extends BaseController
{
    protected $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function login(Request $request)
    {

        $loggedIn = $this->user->login($request->all());

        Log::info($loggedIn);
        if (!$loggedIn) {
            return $this->sendError('Incorrect email or password', [], 401);

        }
        return $this->sendResponse(['name' => 'user', 'value' => $loggedIn], 'The user is authenticated');
    }

    public function logout()
    {
        $loggedOut = $this->user->logout();
        if ($loggedOut) {
            return $this->sendResponse(['name' => 'user', 'value' => $loggedOut], 'You have logged out');

        } else {
            return $this->sendError('Logout Error', [], 400);
        }
    }

    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string'

        ]);

        if ($validation->fails()) {
            return $this->sendError('Invalid request parameters', $validation->errors(), 401);

        }
        $user = $this->user->register($request->all());

        return $this->sendResponse(['name' => 'user', 'value' => $user], 'User has been created');
    }


}
