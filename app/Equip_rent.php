<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equip_rent extends Model
{
    public function equip_rent_record()
    {
        return $this->hasMany('App\Equip_rent_record');
    }
    //    
    protected $fillable= [
        "user_id",
        "name",
        "phone",
        "reason",
        "bringout",
        "cancel",
        "confirmed",
        "start_datetime",
        "end_datetime",
        "paid",
        "return",
        "custom_deposit",
        "custom_start_datetime"
    ];
    
}
