<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teammember extends Model
{
    //
    protected $fillable=[
        "order_id",
        "show",
        "company",
        "name",
        "cover",
        "position",
        "cata",
        "phone",
        "email",
        "content"
    ];
}
