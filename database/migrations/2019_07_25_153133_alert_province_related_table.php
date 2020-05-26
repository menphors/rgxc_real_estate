<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertProvinceRelatedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('district_translations', function (Blueprint $table) {
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
        });

        Schema::table('commune_translations', function (Blueprint $table) {
            $table->foreign('commune_id')->references('id')->on('communes')->onDelete('cascade');
        });

        Schema::table('village_translations', function (Blueprint $table) {
            $table->foreign('village_id')->references('id')->on('villages')->onDelete('cascade');
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
    }
}
