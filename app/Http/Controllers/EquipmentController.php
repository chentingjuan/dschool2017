<?php

namespace App\Http\Controllers;

use App\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
// use App\;
use Auth;
use App\Equip_rent;
use App\Equip_rent_record;

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
            
            return $equip_rent_result;
            // equipment
        }
        

        // $equipment = Equipment::find($equipment->id);
        // return $equipment;
    }


}
