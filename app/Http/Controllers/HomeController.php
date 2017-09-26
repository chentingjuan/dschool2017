<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

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
    public function RegistedEvent(){
        return view("layouts.app_spa");
    }
}
