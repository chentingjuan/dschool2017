<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Facade\Redirect;
use Illuminate\Support\Facades\Input;
use App\Activity;
use App\RegistRecord;
use App\Question;
use Mail;
use Auth;
class ActivityController extends Controller
{

    
    public function index(){
        // dd("test");
        $result = Activity::all();
        // $test = "";
        foreach( $result as $act){
            $act['regist_count']  = $act->regist_list->count();
        }
        return $result;
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
                }else if ($existed_record->status=="CONFIRMED"){
                    return [
                        "status" => "CONFIRMED",
                        "type" => $existed_record->confirm_type
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
         $inputs = Input::all();

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
                    "formdata" => $inputs["formdata"],
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


    //管理員確認此筆紀錄為報名成功
    public function ConfirmRecord($recordId,$action){
        // get record from activityregister user_uuid = current user uuid
        
        if ( Auth::check() ){
            $user = Auth::user();
            if ($user->admingroup=="root"){
                $existed_record = RegistRecord::where('id',$recordId)->where("cancel",false)->first();
                $activity = $existed_record->activity;
                $user = $existed_record->user;
                $data = [
                    'time' => $activity->time_detail,
                    'title'=> $activity->title, 
                    'mailcontent'=> $activity->mailcontent?$activity->mailcontent:"" , 
                    'end_response_date'=> $activity->end_response_date?$activity->end_response_date:"規定日期前"
                ];

                //replace image path to absolute
                $re = '/src=\"\/storage\//';
                $data["mailcontent"] = preg_replace($re , "src=\"http://2017.dschool.ntu.edu.tw/storage/",  $data["mailcontent"]);
                
                $re = '/(dschool2017\.dev)/';
                $data["mailcontent"] = preg_replace($re , "2017.dschool.ntu.edu.tw",  $data["mailcontent"]);
                
                // dd( $data["mailcontent"]);
                // return $data["mailcontent"];

                if ($existed_record){
                    if ($existed_record->status != "CONFIRMED" &&  $action!="cancel"){

                        $existed_record->status = "CONFIRMED";
                        $existed_record->confirm_type = $action;
                        $mail_title = '台大創新設計學院【'.strip_tags($activity->title).'】';
                        if ($action=="yes"){
                            $mail_title .= "錄取通知";
                        }else if ($action=="pending"){
                            $mail_title .= "備取通知";
                        }else if ($action=="no"){
                            $mail_title .= "不錄取通知";
                        }
                        Mail::send('emails.activity.confirm.'.$action , $data , function($message) use ($activity,$user,$mail_title ){
                            $message
                                ->from('ntudschool@ntu.edu.tw','Dschool台大創新設計學院')
                                ->bcc('frank890417@gmail.com', '吳哲宇')
                                ->to($user->email,$user->name)->subject($mail_title);
                        });
                    }else{
                        $existed_record->status = "UNCONFIRMED";
                        $existed_record->confirm_type = null;
                    }
                    $existed_record->save();
                    return [
                        "result" => "success",
                        "log" => "success",
                        "record" => $existed_record
                    ];
                }
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
            if ( array_key_exists('question',$inputs)){
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
            }
            // dd($inputs['question']);
            $activity->update($inputs);
            return $activity;
        }else{
            if ( array_key_exists('question',$inputs)){
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
            }
            $activity=Activity::create($inputs);
            return $activity;
            
        }
        // $activity=Activity::firstOrCreate($activity);

        
    }
    // public function 
}
