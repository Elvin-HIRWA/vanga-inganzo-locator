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
            $table->unsignedBigInteger('userID');
            $table->integer('startTime');
            $table->integer('endTime');
            $table->string('img_path');
            $table->timestamps();


            $table->foreign('userID')->references('id')->on('User')
             ->onDelete('restrict')
               ->onUpdate('cascade');

            $table->unique(['name','venue','startTime','endTime'],'eventPerTime');
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
