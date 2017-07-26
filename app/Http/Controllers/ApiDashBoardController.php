<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiDashBoardController extends Controller
{

    public function index(){

        return view('auth.api-dashboard',['pageTitle' => 'API Dashboard']);

    }
}
