<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOwnerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owner', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 150);
            $table->string('phone', 15);
            $table->string('phone2', 15)->nullable();
            $table->string('phone3', 15)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('address', 500)->nullable();
            $table->string('thumbnail', 250)->nullable();
            $table->text('remark')->nullable();
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
        Schema::dropIfExists('owner');
    }
}
