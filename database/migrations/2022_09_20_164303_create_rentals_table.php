<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('car_id');
            $table->dateTime('date_withdrawal');
            $table->dateTime('date_return_expected');
            $table->dateTime('date_return_realized');
            $table->float('daily_rate', 8, 2);
            $table->integer('km_withdrawal');
            $table->integer('km_return');
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('car_id')->references('id')->on('cars');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropConstrainedForeignId('client_id');
            $table->dropConstrainedForeignId('car_id');
        });

        Schema::dropIfExists('rentals');
    }
}
