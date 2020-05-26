<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });

        Schema::create('type_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
            $table->string('locale', 50)->index();
            $table->unique(['type_id','locale']);
            $table->string('title');
        });

        Schema::create('properties', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('owner_id');
            $table->unsignedInteger('province_id')->nullable();
            $table->unsignedInteger('district_id')->nullable();
            $table->unsignedInteger('commune_id')->nullable();
            $table->unsignedInteger('village_id')->nullable();
            $table->string('code');
            $table->string('listing_type')->nullable(); // ['sale', 'rent']
            $table->float('cost')->nullable()->default(0); // purchase price
            $table->float('price')->nullable()->default(0); // sale price
            $table->float('property_size')->nullable();
            $table->integer('floor_number')->nullable();
            $table->integer('bed_room')->nullable();
            $table->integer('bath_room')->nullable();
            $table->integer('has_parking')->nullable();
            $table->integer('front_refer_to')->nullable()->comment("1 = west, 2 = east, ...");
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->boolean('display_on_maps')->nullable(); // true | false
            $table->integer('year_of_renovation')->nullable();
            $table->integer('year_of_construction')->nullable();
            $table->float('built_up_surface')->nullable();
            $table->float('habitable_surface')->nullable();
            $table->float('ground_surface')->nullable();
            $table->boolean('has_swimming_pool')->nullable();
            $table->boolean('has_elevator')->nullable();
            $table->text('address')->nullable();
            $table->boolean('has_basement')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('status')->nullable(); // [0='pending', 1='submit', 2='complete']
            $table->boolean('is_published')->nullable();
            $table->longText('data')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('type_id')->unsigned()->nullable();
            $table->foreign('type_id')->references('id')->on('types');
            $table->timestamps();
        });

        Schema::create('property_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id')->unsigned();
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->string('locale', 50)->index();
            $table->unique(['property_id','locale']);
            $table->string('title');
            $table->text('remark')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_translations');
        Schema::dropIfExists('properties');
        Schema::dropIfExists('type_translations');
        Schema::dropIfExists('types');
    }
}
