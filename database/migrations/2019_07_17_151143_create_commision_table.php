<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommisionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id')->unsigned()->nullable();
            $table->foreign('property_id')->references('id')->on('properties');
            $table->float('commission')->nullable()->default(0);
            $table->string('to')->nullable();
            // type 1 = commission between staff and company
            //     2 = commission between owner and company
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
        Schema::dropIfExists('commissions');
    }
}
