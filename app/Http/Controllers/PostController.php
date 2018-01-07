<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Program;
use App\Post;
class PostController extends Controller
{
    //
    public function index(){
        return Post::orderBy("date")->get();
    }
    public function show($id){
        $result = Post::find($id);
        return $result;
    }
    public function update($id){
        $inputs = Input::all();
        $post = Post::find($id);
        $post->update($inputs);
        $result =  $post;

        return $result;
    }
    public function destroy($id){
        $post = Post::find($id);
        $post->delete();
        return ["status"=>"success"];
    }
    public function store(){
        $inputs = Input::all();
        $post = Post::create($inputs);
        
        $post = Post::find($post->id);
        return $post;
    }
}
