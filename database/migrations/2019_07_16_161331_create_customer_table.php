<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_card');
            $table->string('email');
            $table->string('phone');
            $table->string('address')->nullable();
            $table->string('fb')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('image')->nullable();
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->boolean('verified_code')->nullable(); // true | false
            $table->datetime('expired')->nullable();
            $table->datetime('last_active')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('customer_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->string('locale', 50)->index();
            $table->unique(['customer_id','locale']);
            $table->string('username');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_translations');
        Schema::dropIfExists('customers');
    }
}
