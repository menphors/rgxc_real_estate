<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staffs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('office_id')->nullable();
            $table->string('id_card');
            $table->string('email');
            $table->string('phone1');
            $table->string('phone2')->nullable();
            $table->string('address')->nullable();
            $table->string('fb')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('image')->nullable();
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->longText('data')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('staff_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('staff_id')->unsigned();
            $table->foreign('staff_id')->references('id')->on('staffs')->onDelete('cascade');
            $table->string('locale', 50)->index();
            $table->unique(['staff_id','locale']);
            $table->string('username');
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff_translations');
        Schema::dropIfExists('staffs');
    }
}
