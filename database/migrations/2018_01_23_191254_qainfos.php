<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Qainfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 
        Schema::create('qainfos',function($table){
            $table->increments('id');
            
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            
            $table->timestamps();
            
            // $table->string('other',1000)->nullable();
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
        Schema::dropIfExists("qainfos");
    }
}
