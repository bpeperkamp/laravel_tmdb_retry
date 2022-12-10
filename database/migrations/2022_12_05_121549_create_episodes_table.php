<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('serie_id');
            $table->foreign('serie_id')->references('id')->on('series');

            $table->unsignedBigInteger('season_id');
            $table->foreign('season_id')->references('id')->on('seasons');

            $table->date('air_date')->nullable();
            $table->text('name')->nullable();
            $table->text('overview')->nullable();
            $table->text('still_path')->nullable();
            $table->integer('season_number')->nullable();
            $table->bigInteger('runtime')->nullable();

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
        Schema::dropIfExists('episodes');
    }
};
