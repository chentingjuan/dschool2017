<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use Illuminate\Support\Facades\Input;
class PageController extends Controller
{
    //
    public function index(){
        return Page::all();
    }
    public function show($title){
        $result = Page::where("title",$title)
                    ->first();
        return $result;
    }
    public function update($title){
        $inputs = Input::all();
        $speaker = Page::where("title",$title)->first();
        $speaker->update($inputs);
        $result =  $speaker;

        return $result;
    }
    public function destroy($id){
        $page = Page::find($id);
        $page->delete();
        return ["status"=>"success"];
    }
    public function store(){
        $inputs = Input::all();
        $page = Page::create($inputs);
        return $page;
    }
}
