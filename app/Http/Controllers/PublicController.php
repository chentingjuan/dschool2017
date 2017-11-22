<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Activity;
class PublicController extends Controller
{
    //
    public function Spa(){
        return view("layouts.app_spa");
    }    //
    public function Activity($activityId){
        $activity=Activity::find($activityId);
        return view("layouts.app_spa")->with([
            "meta_og"=>[
                "title"=> $activity->title. " - Dschool 台大創新設計學院",
                "type"=>"website",
                "url"=>trim(url()->current()),
                "cover"=> $activity->cover,
                "description"=> $activity->description
            ]
        ]);
    }

}
