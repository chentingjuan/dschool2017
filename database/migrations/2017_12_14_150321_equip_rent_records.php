<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EquipRentRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('equip_rent_records',function($table){
            $table->increments('id');
            // $table->integer('event_id')->nullable();
            $table->integer("equipment_id")->nullable();
            $table->integer("equip_rent_id")->nullable();
            $table->string("user_id")->nullable();
            $table->integer("count")->default(0)->nullable();
            $table->string("status")->default("uncofirmed")->nullable();
            $table->text("note")->nullable();
            $table->datetime("start_datetime")->nullable();
            $table->datetime("end_datetime")->nullable();
            $table->timestamps();
        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists("equip_rent_records");
    }
}
