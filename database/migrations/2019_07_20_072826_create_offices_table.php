<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offices', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_main');
            $table->unsignedInteger('province_id')->nullable();
            $table->unsignedInteger('district_id')->nullable();
            $table->unsignedInteger('commune_id')->nullable();
            $table->unsignedInteger('village_id')->nullable();
            $table->string('name');
            $table->string('address', 350)->nullable();
            $table->decimal('latitude', 18, 7);
            $table->decimal('longitude', 18, 7);
            $table->string('phone', 15);
            $table->string('email', 100)->nullable();
            $table->string('picture', 250)->nullable();
            $table->string('thumbnail', 250)->nullable();
            $table->text('description')->nullable();
            $table->longText('data')->nullable()->comment("store json");
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
        Schema::dropIfExists('offices');
    }
}
