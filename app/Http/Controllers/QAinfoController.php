<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\QAinfo;
class QAinfoController extends Controller
{
    //  
    public function index(){
        return QAinfo::all();
    }
    public function show($id){
        $result = QAinfo::where("id",$id)
                    ->first();
        return $result;
    }
    public function update($id){
        $inputs = Input::all();
        $qainfo = QAinfo::find($id);
        $qainfo->update($inputs);
        $result =  $qainfo;

        return $result;
    }
    public function destroy($id){
        $qainfo = QAinfo::find($id);
        $qainfo->delete();
        return ["status"=>"success"];
    }
    public function store(){
        $inputs = Input::all();
        $qainfo = QAinfo::create($inputs);
        return $qainfo;
    }
}
