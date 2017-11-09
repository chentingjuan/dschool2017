<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EventAddQuestion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('activities', function (Blueprint $table) {
            $table->json('question')->nullable();
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
            $table->dropColumn('question')->nullable();
            // $table->string('other',1000)->nullable();
        });
    }
}
