<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertOwnerIdToNullPropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->integer('province_id')->nullable()->default(null)->change();
            $table->integer('district_id')->nullable()->default(null)->change();
            $table->integer('commune_id')->nullable()->default(null)->change();
            $table->integer('village_id')->nullable()->default(null)->change();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
