<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->float('amount')->nullable()->default(0);
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('contract_id')->unsigned()->nullable();
            $table->foreign('contract_id')->references('id')->on('contracts');
            $table->integer('property_id')->unsigned()->nullable();
            $table->foreign('property_id')->references('id')->on('properties');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_transactions');
    }
}
