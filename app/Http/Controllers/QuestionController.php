<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Question;
class QuestionController extends Controller
{
    //  
    public function index(){
        return Question::all();
    }
    public function show($id){
        $result = Question::where("id",$id)
                    ->first();
        return $result;
    }
    public function update($id){
        $inputs = Input::all();
        $question = Question::find($id);
        $question->update($inputs);
        $result =  $question;

        return $result;
    }
    public function destroy($id){
        $question = Question::find($id);
        $question->delete();
        return ["status"=>"success"];
    }
    public function store(){
        $inputs = Input::all();
        $question = Question::create($inputs);
        return $question;
    }
}
