<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommunesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('district_id');
            $table->string('code');
            $table->timestamps();
        });

        Schema::create('commune_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('commune_id')->unsigned();
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
        Schema::dropIfExists('commune_translations');
        Schema::dropIfExists('communes');
    }
}
