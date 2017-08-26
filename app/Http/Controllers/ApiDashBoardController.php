<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiDashBoardController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(){

        return view('auth.api-dashboard',['pageTitle' => 'API Dashboard']);

    }
}
