<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_staff', function (Blueprint $table) {
            $table->integer('property_id')->unsigned()->nullable();
            $table->foreign('property_id')->references('id')->on('properties');
            $table->integer('staff_id')->unsigned()->nullable();
            $table->foreign('staff_id')->references('id')->on('staffs');
            $table->integer('type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_staff');
    }
}
