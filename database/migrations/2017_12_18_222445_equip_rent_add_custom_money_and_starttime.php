<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EquipRentAddCustomMoneyAndStarttime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        ////
         Schema::table('equip_rents', function (Blueprint $table) {
             $table->integer('custom_deposit')->nullable();
             $table->datetime('custom_start_datetime')->nullable();
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
        ////
         Schema::table('equip_rents', function (Blueprint $table) {
             $table->dropColumn('custom_deposit');
             $table->dropColumn('custom_start_datetime');
             // $table->string('other',1000)->nullable();
         });
    }
}
