<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Facade\Redirect;
use App\Activity;
use App\RegistRecord;
use Auth;
class ActivityController extends Controller
{

    
    public function index(){
        return Activity::all();
    }

    public function show($id){
        $activitydaa = Activity::find($id);
        return view('layouts/app_spa');
    }

    //
    public function getActivityStatus($activityId){
        // return Auth::user();
        if ( Auth::check() ){
            $user = Auth::user();
            // return $user;
            // Activity::find($activityId)

            $existed_record = RegistRecord::where('user_id',$user->id)->where("cancel",false)->first();
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

            $existed_record = RegistRecord::where('user_id',$user->id)->where("cancel",false)->first();
            if (!$existed_record){
                $record = RegistRecord::create([
                    "user_id" => $user->id,
                    "activity_id" => $activityId,
                    "created_at" => date("Y-m-d H:i:s"),
                    "updated_at" => date("Y-m-d H:i:s")
                ]);
                return  [
                    "result" => $record,
                    "status" => "success"
                ];
            }else{
                return  [
                    "result" => $existed_record,
                    "status" => "repeated"
                ];
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
        if ( Auth::check() ){
            $user = Auth::user();
            // return $user;
            // Activity::find($activityId)

            $existed_record = RegistRecord::where('user_id',$user->id)->where("cancel",false)->first();
            
            if ($existed_record){
                $existed_record->cancel = true;
                $existed_record->save();
                return [
                    "result" => "success",
                    "log" => "success",
                    "record" => $existed_record
                ];
            }
            
            
            // confirm activity 
        }else{
            // login or regist -> confirm activity
            return [
                "result" => "fail",
                "log" => "need login",
                "redirect" => "/login"
            ];
        }
        
        // turn cancel to true
    }

    public function store($data){

    }
    
    public function update($activityId){
        dd("test");
        $input=Input::all();
        $activity=Activity::find($activityId);
        $input['updated_at']=date("Y-m-d H:i:s");
        $activity->update($input);
        return $activity;
        
    }
    // public function 
}
