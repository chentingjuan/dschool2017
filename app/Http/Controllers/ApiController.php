<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\File;
use Storage;
use Auth;
use App\User;
use App\Activity;
use Intervention\Image\ImageManagerStatic as Image;

class ApiController extends Controller
{
    //activity
    public function getActivityById($id){
        return Activity::find($id);
    }

    public function getAllRegistedEvent(){
        
        if ( Auth::check() ){
            $user = Auth::user();
            $registRecord= $user->registRecords()->where("cancel",false)->get();
            return $registRecord;
        }else{
            return [];
        }
    }

    public function getEventRegisterList($activityId){
        
        if ( Auth::check() ){
            $user = Auth::user();
            if ($user->admingroup=="root"){
                $activity = Activity::find($activityId);
                return $activity->registRecords()->with("user")->where("cancel",false)->get();
            }
        }
    }

    public function getUserList(){
        if ( Auth::check() ){
            $user = Auth::user();
            if ($user->admingroup=="root"){
                return User::all();
            }
        }
    }


    public function upload_image(){
        $input = Input::all();
        if(Input::file())
         {
  
  
           $image = Input::file('file');
           // $ext = $image->getClientOriginalExtension();
           $filename  =  date('Y_m_d_h_i_s').'_'. $_FILES['file']['name'] ;
  
           // prevent possible upsizing
           // dd("storage/".$filename);
           $img = Image::make($image);
           $img->resize(1920, null, function ($constraint) {
               $constraint->aspectRatio();
               $constraint->upsize();
           });
  
           $path = 'img/uploaded/';
           
           $img->save(storage_path('app/'.$path.$filename));
           // dd($img->__toString());
          
           Storage::put($path.$filename,$img->__toString());
  
  
           return '/storage/'.$path.str_replace(" ","%20",$filename);
       
               // Image::make($image->getRealPath())->resize(200, 200)->save($path);
               // $user->image = $filename;
               // $user->save();
        }
    }
    

}
