<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activity;

class ManageController extends Controller
{
    public function Spa(){
        return view('layouts.app_spa');
    }
    //
    public function Activity($id){
        return view('layouts.app_spa');
    }
    //
    public function ActivityEdit($id){
        return view('layouts.app_spa');
    }

    
}
