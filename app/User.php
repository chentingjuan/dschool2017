<?php

namespace App;

use Laravel\Passport\HasApiTokens; //use HasApiTokens
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Webpatser\Uuid\Uuid;

class User extends Authenticatable
{

    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','uuid','type','name','phone','email','agency','school','department','student_id','admingroup','created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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


    public function registRecords(){
        return $this->hasMany('App\Registrecord', 'user_id', 'id');
    }

    // public function edit(Model $model)
    // {
    //    return view('someview.edit')->with([
    //         'model' => $model,
    //     ]);
    // }
}
