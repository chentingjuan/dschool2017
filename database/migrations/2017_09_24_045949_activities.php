<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Activities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('activities', function (Blueprint $table) {
             $table->increments('id');
             $table->string('uuid');
             $table->string('type')->default("event");
             $table->string('title');
             $table->string('description',400);
             $table->string('place')->nullable();
             $table->datetime('open_time')->nullable();
             $table->datetime('close_time')->nullable();
             $table->datetime('time');
             $table->string('time_detail');
             $table->text('detail')->nullable();
             $table->text('register_info')->nullable();
             $table->json('teacher')->nullable();
             $table->string('cover')->nullable();
             $table->json('album')->nullable();
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
         Schema::dropIfExists('activities');
     }
}
