<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equip_rent_record extends Model
{
    //
    public function equipment()
    {
        return $this->hasOne('App\Equipment','id','equipment_id');
    }
    protected $fillable = [
        "equipment_id",
        "equip_rent_id",
        "user_id",
        "count",
        "status",
        "note",
        "start_datetime",
        "end_datetime",
    ];

    

}
