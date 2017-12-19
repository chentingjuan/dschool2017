<?php

namespace App\Http\Controllers;

use App\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
// use App\;
use Auth;
use App\Equip_rent;
use App\Equip_rent_record;
use Mail;

class EquipmentController extends Controller
{
    //
    public function index(){
        return Equipment::all();
    }
    public function show($id){
        $result = Equipment::find($id);
        return $result;
    }
    public function update($id){
        $inputs = Input::all();
        $equipment = Equipment::find($id);
        $equipment->update($inputs);
        $result =  $equipment;

        return $result;
    }
    public function destroy($id){
        $equipment = Equipment::find($id);
        $equipment->delete();
        return ["status"=>"success"];
    }
    public function store(){
        $inputs = Input::all();
        $equipment = Equipment::create($inputs);
        
        $equipment = Equipment::find($equipment->id);
        return $equipment;
    }


    public function rent(){
        $inputs = Input::all();
        $equipments = $inputs["equips"];

        if (Auth::check()){
            $user = Auth::user();
            $equip_rent = Equip_rent::create([
                "user_id" => $user->id,
                "name" =>  $inputs["name"],
                "phone" =>  $inputs["phone"],
                "reason" =>  $inputs["reason"],
                "bringout" =>  $inputs["bringout"],
                "start_datetime" =>  $inputs["start_datetime"],
                "end_datetime" =>  $inputs["end_datetime"],
            ]);
            $equip_rent_id=$equip_rent->id;
            $equips = [];
            foreach($equipments as $equip){
                
                $equip = Equip_rent_record::create([
                    "equipment_id" => $equip['id'],
                    "equip_rent_id" => $equip_rent->id,
                    "count" => $equip["count"],
                    // "start_datetime" => $equip["count"],
                    // "status" => $equip["status"]
                ]);

               
                // array_push($equips,$equip );
            }
            

            // return $equip_rent->equip_rent_record()->get();
            $equip_rent_result= Equip_rent::where("id",$equip_rent_id)->with('equip_rent_record')->first();
            foreach($equip_rent_result['equip_rent_record'] as $equip){
                $equip["equipment"]=$equip->equipment;
            }
            // dd($equip_rent_result->toArray());
            $mail_title="設備租用申請通知#".$equip_rent->id." - ".$inputs["name"];
            Mail::send('emails.equipment.notifymanage', $equip_rent_result->toArray(), function($message) use ($mail_title){
                $message
                    ->from('ntudschool@ntu.edu.tw','Dschool台大創新設計學院')
                    ->bcc('frank890417@gmail.com', '吳哲宇')
                    ->to('ntudschool@ntu.edu.tw', '台大創新設計學院 設備管理')
                    ->subject($mail_title);
            });

            return $equip_rent_result;
            // equipment
        }
        

      
        // $equipment = Equipment::find($equipment->id);
        // return $equipment;
    }

    public function confirm(){
        $inputs = Input::all();
        // dd($inputs);
        // return print_r($inputs);
        


        if (Auth::check()){
            $user = Auth::user();
            Equip_rent::find($inputs['id'])
                ->update($inputs);
            Equip_rent::find($inputs['id'])
                ->update(["confirmed"=>true]);     
            //如果是取消就設定confirmed=false (記得不要改到cancel，是取消此單)
            if (array_key_exists("cancel_confirm",$inputs) && $inputs["cancel_confirm"]){
                Equip_rent::find($inputs['id'])
                ->update(["confirmed"=>false]);  
            }
            foreach($inputs['equip_rent_record'] as $equip){
                Equip_rent_record::find($equip['id'])->update( $equip);
            }
            $equip_rent_result= Equip_rent::where("id",$inputs['id'])->with('equip_rent_record')->with('user')->first();
            $total_deposit=0;
            foreach($equip_rent_result['equip_rent_record'] as $equip){
                $equip["equipment"]=$equip->equipment;
                $total_deposit+=$equip["equipment"]['deposit']?$equip["equipment"]['deposit']:0;
            }

            if (array_key_exists("cancel_confirm",$inputs) && $inputs["cancel_confirm"]){
            }else{
                // $equip_rent = Equip_rent::find($inputs['id'])->with('user')->get();
                $usedata = $equip_rent_result->toArray();
                $usedata['ensure_money']=$equip_rent_result['custom_deposit']?$equip_rent_result['custom_deposit']:$total_deposit ;
                $usedata['start_datetime']=$usedata['custom_start_datetime']?$usedata['custom_start_datetime']:$usedata['start_datetime'];

                $mail_title="【創新設計學院】設備借用審核結果 #".$equip_rent_result->id." - ".$inputs["name"];
                Mail::send('emails.equipment.notifyresult', $usedata , function($message) use ($mail_title,$equip_rent_result ){
                    $message
                        ->from('ntudschool@ntu.edu.tw','Dschool台大創新設計學院')
                        ->bcc('frank890417@gmail.com', '吳哲宇')
                        ->to($equip_rent_result->user->email,$equip_rent_result->user->name)
                        ->subject($mail_title);
                });
                return ["status"=>"ok!","data"=>$equip_rent_result];

            }
            return ["status"=>"error","data"=>$equip_rent_result];
        }
    }

}
