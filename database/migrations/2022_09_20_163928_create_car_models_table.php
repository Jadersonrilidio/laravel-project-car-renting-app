<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_models', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_id');
            $table->string('name', 30);
            $table->string('image', 128);
            $table->integer('num_doors');
            $table->integer('num_passengers');
            $table->boolean('air_bag');
            $table->boolean('abs');
            $table->timestamps();

            $table->foreign('brand_id')->references('id')->on('brands');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('car_models', function (Blueprint $table) {
            $table->dropConstrainedForeignId('brand_id');
        });
        
        Schema::dropIfExists('car_models');
    }
}
