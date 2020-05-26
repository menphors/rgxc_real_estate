<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        [
            'start_date', 
            'end_date', 
            'commission', 
            'amount',
        ];

        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->float('amount')->nullable()->default(0);
            $table->float('commission')->nullable()->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('data')->nullable();
            $table->date('create_on')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            
            $table->integer('customer_id')->unsigned()->nullable();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->integer('staff_id')->unsigned()->nullable();
            $table->foreign('staff_id')->references('id')->on('staffs');
            $table->integer('property_id')->unsigned()->nullable();
            $table->foreign('property_id')->references('id')->on('properties');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            // Type: 1 = contract between company and owner
            //   2 = contract between owner and customer
            //   3 = deposit
            $table->integer('type')->unsigned()->nullable();
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
        Schema::dropIfExists('contracts');
    }
}
