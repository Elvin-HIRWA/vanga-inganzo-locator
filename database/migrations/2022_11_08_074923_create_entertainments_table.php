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
        Schema::create('Entertainment', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('venue');
            $table->unsignedBigInteger('contractorID');
            $table->unsignedBigInteger('contracteeID');
            $table->integer('startTime');
            $table->integer('endTime');
            $table->integer('EventDate');
            $table->string('img_path');
            $table->timestamps();


            $table->foreign('contractorID')->references('id')->on('User')
             ->onDelete('restrict')
               ->onUpdate('cascade');

            $table->foreign('contracteeID')->references('id')->on('Contractee')
               ->onDelete('restrict')
                 ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Entertainment');
    }
};
