<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Course;
use Auth;
class CourseController extends Controller
{
    //  

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index','show']]);
    }

    public function index(){
        return Course::all();
    }
    public function show($id){
        $result = Course::where("id",$id)
                    ->first();
        return $result;
    }
    public function update($id){
        $inputs = Input::except(['token']);
        $course = Course::find($id);
        $course->update($inputs);
        $result =  $course;

        return $result;
    }

    public function updateAll(){
        $inputs = Input::all();
        foreach ($inputs['courses'] as $data){
            $course = Course::find($data['id']);
            $course->update($data);
        }
        return ["status"=>"success"];
    }
    public function destroy($id){
        $course = Course::find($id);
        $course->delete();
        return ["status"=>"success"];
    }
    public function store(){
        $inputs = Input::except(['token']);
        $course = Course::create($inputs);
        return $course;
    }
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}
