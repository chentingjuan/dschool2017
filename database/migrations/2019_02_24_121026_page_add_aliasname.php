<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PageAddAliasname extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('pages', function (Blueprint $table) {
            $table->string('name')->default('');
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
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('name');
            // $table->string('other',1000)->nullable();
        });
    }
}
