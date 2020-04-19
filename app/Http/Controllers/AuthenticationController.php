<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Salon\User\UserInterface;
Use Log;

class AuthenticationController extends BaseController
{
    protected $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function login(Request $request)
    {
        //return $this->sendResponse(['name' => 'info', 'value' => $request->input('password')],'Blah');
        $loggedIn = $this->user->login($request->all());

        Log::info($loggedIn);
        if(!$loggedIn)
        {
            return $this->sendError('Incorrect email or password',[], 401);

        }
        return $this->sendResponse(['name' => 'user', 'value' => $loggedIn], 'The user is authenticated');
    }
}
