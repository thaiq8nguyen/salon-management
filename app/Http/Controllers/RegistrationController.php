<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
use Illuminate\Http\Request;
use App\Technician;
use App\User;
use Auth;

class RegistrationController extends Controller
{
    public function __construct()
    {


        $this->middleware('completed.registration')->only('postRegister');
    }

    public function index(){




        return view('auth.register');
    }

    public function register(Request $request){

        $this->validate($request,[
            'invitation' => 'required|exists:technicians,id',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',

        ]);

        //check invitation number -- ok
        $technicianId = $request->input('invitation');
        $email = $request->input('email');
        $password = $request->input('password');
        $userCount = User::where('technician_id','=',$technicianId)->count();

        if($userCount == 1){
            $request->session()->put('completed_registration');
            return redirect()->route('post-register')->with('error','The account is already existed. Please contact the business manager for assistance');
        }

        $technician = Technician::find($technicianId);

        //create unique username
        $index = 0;
        $duplicateUserName = true;
        $username = null;
        while($duplicateUserName){

            $username = strtolower(substr($technician->first_name,0,1)).strtolower($technician->last_name).$index;
            if(User::where('username','=',$username)->count() == 0){
                if(substr($username,-1) == '0'){
                    $username = substr_replace($username,null,-1);
                }
                $duplicateUserName = false;
            }
            $index++;
        }

        //create the user
        $technician->user()->create(['name' => $technician->full_name,
            'email' => $email, 'password' => bcrypt($password),'username' => $username ]);


        //redirect user to successful confirmation page
        $request->session()->put('completed_registration');

        if(Auth::attempt(['username' => $username, 'password' => $password])){

            //Fire UserRegisteredEvent

            event(new UserRegistered(Auth::user())); //send an authenticated model to the event

            return redirect()->route('post-register')->

            with('success','Thank you for registering, '.$technician->full_name);
        }
        else{
            $request->session()->put('completed_registration');
            return redirect()->route('post-register')
                ->with('error','There have been errors logging into your account. Please contact the business manager for assistance');
        }


    }

    public function postRegister(){

        session()->forget('completed_registration');
        return view('auth.post-register');


    }
}
