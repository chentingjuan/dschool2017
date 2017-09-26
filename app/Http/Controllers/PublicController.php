<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    //
    public function Activity(){
        return view("layouts.app_spa");
    }

}
