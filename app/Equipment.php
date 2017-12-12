<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    //
    protected $table = "equipments";
    // 
    protected $fillable = [
        "auth","cata","name","model","count",
        "accessories","other_accessories","deposit","status",
        "created_at","updated_at"
    ];
}
