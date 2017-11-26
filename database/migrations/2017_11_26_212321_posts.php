<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Posts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('posts',function($table){
            $table->increments('id');
            // $table->integer('event_id')->nullable();
            $table->string("title")->nullable();
            $table->string("subtitle")->nullable();
            $table->text("description")->nullable();
            $table->integer("author")->nullable();
            $table->string("cover",500)->nullable();
            $table->string("cata")->nullable();
            $table->date("date")->nullable();
            $table->boolean("show")->default(false)->nullable();
            $table->json("tags")->nullable();
            $table->string("link",500)->nullable();
            $table->text("content")->nullable();
            // $table->integer("agency")->nullable();
            $table->boolean("stick")->default(false);
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
        Schema::dropIfExists('posts');
    }
}
