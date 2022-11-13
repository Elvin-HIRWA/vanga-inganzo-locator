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
        Schema::create('KeyPermission', function (Blueprint $table) {
            $table->id();
            $table->string('value');   // this is key value 
            $table->unsignedBigInteger('permissionID');  // foreign key
            $table->timestamps();

            $table->foreign('permissionID')->references('id')->on('Permission')
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
        Schema::dropIfExists('KeyPermission');
    }
};
