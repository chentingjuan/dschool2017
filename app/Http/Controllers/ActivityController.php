<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Facade\Redirect;
use Illuminate\Support\Facades\Input;
use App\Activity;
use App\RegistRecord;
use App\Question;
use Auth;
class ActivityController extends Controller
{

    
    public function index(){
        // dd("test");
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

            $existed_record = RegistRecord::where('user_id',$user->id)->where('activity_id',$activityId)->where("cancel",false)->first();
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
                $activity=Activity::find($activityId);
                //有開頭時間沒結尾
                if ($activity->open_time && !$activity->close_time){
                    if (strtotime($activity->open_time) < strtotime("now")){
                        
                    }else{
                        return [
                            "status" => "not_open"
                        ];

                    }

                }
                //有結尾時間沒開頭
                if (!$activity->open_time && $activity->close_time){
                    if (strtotime($activity->close_time) > strtotime("now")){
                        
                    }else{
                        return [
                            "status" => "not_open"
                        ];

                    }

                }
                if ($activity->open_time && $activity->close_time){
                    if (strtotime($activity->open_time) < strtotime("now")
                        && strtotime($activity->close_time) > strtotime("now")){
                        
                    }else{
                        return [
                            "status" => "not_open"
                        ];

                    }

                }
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
            $existed_record = RegistRecord::where('user_id',$user->id)->where('activity_id',$activityId)->where("cancel",false)->first();
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

            $existed_record = RegistRecord::where('user_id',$user->id)->where('activity_id',$activityId)->where("cancel",false)->first();
            
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
    

    public function destroy($id){
        // delete
        $nerd = Activity::find($id);
        $nerd->delete();
        return [
            'status'=>true
        ];
    }
            

    public function update($activity){
        // dd("test");
        $inputs=Input::all();
        $activity=Activity::find($activity);
        if ($activity){
            $inputs['updated_at']=date("Y-m-d H:i:s");
            $qlists = [];
            foreach ( $inputs['question'] as $qa){
                // dd(gettype($qa));
                if (gettype($qa)=="array"){
                    
                    $qa_obj = Question::where('id',$qa['id'])->first();
                    if ( $qa_obj){
                        $qa_obj->update($qa);
                        $qa_obj->save($qa);
                        // dd($qa);
                        array_push($qlists,$qa['id']);
                    }                
                }else{
                    array_push($qlists,$qa);

                }
            }
            $inputs['question']=json_encode($qlists);
            // dd($inputs['question']);
            $activity->update($inputs);
            return $activity;
        }else{
            $activity=Activity::create($inputs);
            return $activity;
            
        }
        // $activity=Activity::firstOrCreate($activity);

        
    }
    // public function 
}
