<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Activity;
class ApiController extends Controller
{
    //activity
    public function getActivityById($id){
        return Activity::find($id);
    }

    public function getAllRegistedEvent(){
        
        if ( Auth::check() ){
            $user = Auth::user();
            $registRecord= $user->registRecords()->where("cancel",false)->get();
            return $registRecord;
        }
    }

}
