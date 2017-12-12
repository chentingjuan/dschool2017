<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Equipment;

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

}
