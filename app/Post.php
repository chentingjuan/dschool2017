<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $fillable = [
        "event_id","title","author","cover","date","cata","tags","link","description","content","agency","show"
    ];
}

