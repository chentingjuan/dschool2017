<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QAinfo extends Model
{
    //
    protected $table = "qainfos";
    protected $fillable = [
        'title','content','created_at','updated_at'
    ];
}
