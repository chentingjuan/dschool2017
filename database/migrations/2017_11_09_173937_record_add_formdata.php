<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecordAddFormdata extends Migration
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
             $table->json('formdata')->nullable();
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
         Schema::table('registrecords', function (Blueprint $table) {
             $table->dropColumn('formdata');
             // $table->dropColumn('other');
            
         });
     }
}
