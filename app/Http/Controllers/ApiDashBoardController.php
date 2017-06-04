<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiDashBoardController extends Controller
{
    public function __invoke()
    {
        // TODO: Implement __invoke() method.

        return view('auth.api-dashboard');
    }
}
