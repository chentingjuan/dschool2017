<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Equipments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('equipments',function($table){
            $table->increments('id');
            // $table->integer('event_id')->nullable();
            $table->string("name")->nullable();
            $table->string("cata")->nullable();
            $table->string("cover")->nullable();
            $table->string("auth")->nullable();
            $table->boolean("show")->nullable()->default(true);
            $table->string("model")->nullable();
            $table->integer("count")->nullable()->default(0);
            $table->string("accessories",600)->nullable();
            $table->string("other_accessories",600)->nullable();
            $table->text("other")->nullable();
            $table->integer("deposit")->nullable()->default(0);
            $table->string("status")->nullable();
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
        Schema::dropIfExists("equipments");
    }
}
