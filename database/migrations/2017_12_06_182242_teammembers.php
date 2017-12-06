<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Teammembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        //
        Schema::create('teammembers',function($table){
            $table->increments('id');
            $table->integer("order_id")->nullable()->default(-1);
            $table->boolean("show")->default(false)->nullable();
            $table->string("company")->nullable();
            $table->string("name")->nullable();
            $table->string("cover",500)->nullable();
            $table->string("position")->nullable();
            $table->string("cata")->nullable();
            $table->string("phone")->nullable();
            $table->string("email")->nullable();
            $table->text("content")->nullable();
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
        Schema::dropIfExists('teammembers');
    }
}
