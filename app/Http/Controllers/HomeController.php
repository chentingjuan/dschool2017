<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('layouts.app_spa');
    }


    public function userlist(){
        if (Auth::check()){
            return 'user is logged in'.Auth::user();
        }       

        return User::all();
    }

    public function testmail(){
        $user = ["email"=>"frank890417@gmail.com","name"=>"吳哲宇"];
        Mail::send('emails.reminder', ['user' => $user], function ($m) use ($user) {
            $m->from('hello@app.com', 'Your Application');
            $m->to($user["email"], $user["name"])->subject('Your Reminder!');
        });
    }
}
