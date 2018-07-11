<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Course;
use Auth;
use Mail;
class CourseController extends Controller
{
    //  

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index','show','wish']]);
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

    public function wish(){
        $inputs = Input::all();
        $mail_title = "D-School 官網課程許願";
        Mail::send('emails.course.wish', $inputs , function($message) use ($inputs,$mail_title ){
            $message
                ->from('noreply_service_dschool@ntu.edu.tw','Dschool台大創新設計學院')
                ->bcc('frank890417@gmail.com', '吳哲宇')
                ->to('ntudschool@ntu.edu.tw','Dschool網站管理')
                ->subject($mail_title);
        });
        return ["status"=>"success"];
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
