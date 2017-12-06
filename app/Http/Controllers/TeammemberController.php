<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Teammember;
class TeammemberController extends Controller
{
    //  
    public function index(){
        return Teammember::all();
    }
    public function show($id){
        $result = Teammember::where("id",$id)
                    ->first();
        return $result;
    }
    public function update($id){
        $inputs = Input::all();
        $teammember = Teammember::find($id);
        $teammember->update($inputs);
        $result =  $teammember;

        return $result;
    }
    public function destroy($id){
        $teammember = Teammember::find($id);
        $teammember->delete();
        return ["status"=>"success"];
    }
    public function store(){
        $inputs = Input::all();
        $teammember = Teammember::create($inputs);
        return $teammember;
    }
}
