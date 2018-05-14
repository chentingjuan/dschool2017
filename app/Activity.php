<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;
use App\RegistRecord;
use App\CustomCollection;


class Activity extends Model
{
    //
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
       'type','title','place','description','content','register_info',
       'album','time','open_time','close_time','time_detail',
       'cover','maincover','teacher','question','mailcontent','end_response_date',
       'mode'
    ];


    //uuid for key operation 
    //https://github.com/webpatser/laravel-uuid

    /**
    *  Setup model event hooks
    */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    /**
    * Get the route key for the model.
    *
    * @return string
    */
    // public function getRouteKeyName()
    // {
    //     return 'uuid';
    // }

    public function RegistRecords(){
        return $this->hasMany('App\RegistRecord', 'activity_id', 'id');
    }


    public function getRegistListAttribute(){
        return $this->RegistRecords()->with("user")->where("cancel",false)->get();
    }

    // public function getRegistCountAttribute(){
    //     return $this->regist_list->count();
    // }

    // add count property on collection
    // public function newCollection(array $models = [])
    // {
    //     $models['regist_count']=$this->regist_list->count();
    //     return $models);
    // }

}
