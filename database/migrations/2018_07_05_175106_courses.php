<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Courses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('courses',function($table){
            $table->increments('id');
            // $table->integer('event_id')->nullable();
            $table->integer("order_id")->default(-1);
            $table->string("type")->nullable();
            $table->string("title")->nullable();
            $table->string("code")->nullable();
            $table->string("teacher")->nullable();
            $table->text("schedule")->nullable();
            $table->string("place")->nullable();
            $table->string("planetName")->nullable();
            $table->string("planetSrc",500)->nullable();
            $table->text("notice")->nullable();
            $table->text("content")->nullable();

            // $table->integer("equip_rent_id")->nullable();
            // $table->string("user_id")->nullable();
            // $table->integer("count")->default(0)->nullable();
            // $table->string("status")->default("unconfirmed")->nullable();
            // $table->text("note")->nullable();
            // $table->datetime("start_datetime")->nullable();
            // $table->datetime("end_datetime")->nullable();
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
        Schema::dropIfExists("courses");
    }
}
