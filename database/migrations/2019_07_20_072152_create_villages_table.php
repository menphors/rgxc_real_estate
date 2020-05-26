<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVillagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('villages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('commune_id');
            $table->string('code');
            $table->timestamps();
        });

        Schema::create('village_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('village_id')->unsigned();
            $table->string('locale', 10);
            $table->string('title', 100);
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
        Schema::dropIfExists('village_translations');
        Schema::dropIfExists('villages');
    }
}
