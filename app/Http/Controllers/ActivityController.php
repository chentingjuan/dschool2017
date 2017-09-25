<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Facade\Redirect;
use App\Activity;
use App\Registrecord;
use Auth;
class ActivityController extends Controller
{

    public function show($id){
        $activitydaa = Activity::find($id);
        return view('layouts/app_spa');
    }
    //
    public function getActivityStatus($activityId){
        if ( Auth::check() ){
            $user = Auth::user();
            // return $user;
            // Activity::find($activityId)

            $existed_record = Registrecord::where('user_id',$user-n>id)->first();
            if ($existed_record){
                return [
                    "status" => "registed"
                ];
            }else{
                return [
                    "status" => "not registed"
                ];
            }
        }else{
            return [
                "status" => "need login"
            ];
        }
    }

    //
    public function registActivity($activityId){

        if ( Auth::check() ){
            $user = Auth::user();
            // return $user;
            // Activity::find($activityId)

            $existed_record = Registrecord::where('user_id',$user->id)->first();
            if (!$existed_record){
                $record = Registrecord::create([
                    "user_id" => $user->id,
                    "activity_id" => $activityId,
                    "created_at" => date("Y-m-d H:i:s"),
                    "updated_at" => date("Y-m-d H:i:s")
                ]);
                return $record;
            }else{
                return $existed_record;
            }
            
            
            // confirm activity 
        }else{
            // login or regist -> confirm activity
            return [
                "result" => "fail",
                "status" => "need login",
                "redirect" => "/login"
            ];
        }

        // return "no user";

    }

    //
    public function cancelRegistActivity($activityId){
        // get record from activityregister user_uuid = current user uuid
        // turn cancel to true
    }

    public function store($data){

    }
    // public function 
}
