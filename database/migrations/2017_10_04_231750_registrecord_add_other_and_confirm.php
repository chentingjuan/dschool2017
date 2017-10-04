<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RegistrecordAddOtherAndConfirm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('registrecords', function (Blueprint $table) {
            $table->string('status');
            $table->string('other',400);
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
        Schema::table('registrecords', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('other');
           
        });
    }
}
