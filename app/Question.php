<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Question extends Model
{
    //
    protected $fillable = [
        'question','options','type','answer'
    ];
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

}
