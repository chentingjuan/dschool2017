<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $fillable = [
        "event_id","title","author","cover","cata","tags","link","content","agency"
    ];
}

