<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;
class Activity extends Model
{
    //
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'title','place','description','register_info','time_detail','cover'
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
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function RegistRecords(){
        return $this->hasMany('App\RegistRecord', 'activity_id', 'id');
    }

}
