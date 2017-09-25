<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Registrecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('registrecords', function (Blueprint $table) {
             $table->increments('id');
             $table->string('uuid');
             $table->integer("activity_id");
             $table->integer("user_id");
             $table->string("other",500)->default("");
             $table->boolean("cancel")->default(false);
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
         Schema::dropIfExists('registrecords');
     }
}
