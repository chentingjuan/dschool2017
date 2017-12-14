<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EquipRents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('equip_rents',function($table){

            $table->increments('id');
            $table->string("user_id")->integer();
            $table->string("name")->nullable();
            $table->string("phone")->nullable();
            $table->string("reason")->nullable();

            $table->boolean("bringout")->nullable()->default(false);
            $table->boolean("cancel")->nullable()->default(false);
            $table->boolean("confirmed")->nullable()->default(false);
            $table->boolean("paid")->nullable()->default(false);
            $table->boolean("return")->nullable()->default(false);
            
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
        Schema::dropIfExists("equip_rents");
    }
}
