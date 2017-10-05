<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Facade\Redirect;
use Illuminate\Support\Facades\Input;
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
                if ($existed_record->status=="UNCONFIRMED"){
                    return [
                        "status" => "UNCONFIRMED"
                    ];
                }else if ($existed_record->status=="UNCONFIRMED"){
                    return [
                        "status" => "REGISTED"
                    ];
                }
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
            $activity=Activity::find($activityId);
            $existed_record = RegistRecord::where('user_id',$user->id)->where("cancel",false)->first();
            $record_count = $activity->registRecords()->count();
            if (!$existed_record){
                $record = RegistRecord::create([
                    "user_id" => $user->id,
                    "activity_id" => $activityId,
                    "status" => "UNCONFIRMED",
                    "created_at" => date("Y-m-d H:i:s"),
                    "updated_at" => date("Y-m-d H:i:s"),
                    "serial" => $record_count+1
                ]);
                $record->save();
                return  [
                    "status" => "success",
                    "record" => $record
                ];
            }else{
                return  [
                    "status" => "repeated",
                    "record" => $existed_record
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
    
    public function update($activity){
        // dd("test");
        $input=Input::all();
        $activity=Activity::find($activity);
        $input['updated_at']=date("Y-m-d H:i:s");
        $activity->update($input);
        return $activity;
        
    }
    // public function 
}
