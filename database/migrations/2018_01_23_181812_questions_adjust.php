<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class QuestionsAdjust extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn(['uuid','question','answer']);
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            
            
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
        Schema::table('activities', function (Blueprint $table) {
            $table->string('uuid')->nullable();
            $table->dropColumn(['title','content']);
            // $table->string('other',1000)->nullable();
        });
    }
}
