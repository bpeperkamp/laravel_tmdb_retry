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
        Schema::create('serie_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('serie_id');
            $table->foreign('serie_id')->references('id')->on('series');

            $table->boolean('adult')->default(false);
            $table->date('first_air_date')->nullable();
            $table->date('last_air_date')->nullable();
            $table->text('original_language')->nullable();
            $table->text('status')->nullable();
            $table->text('overview')->nullable();
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
        Schema::dropIfExists('serie_details');
    }
};
