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
        Schema::create('collegequestions', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->unsignedBigInteger('sem_id');
            $table->foreign('sem_id')->references('id')->on('semesters');
            $table->unsignedBigInteger('sub_id');
            $table->foreign('sub_id')->references('id')->on('subjects');
            $table->unsignedBigInteger('collegeyear_id');
            $table->foreign('collegeyear_id')->references('id')->on('collegeyears');
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
        Schema::dropIfExists('collegequestions');
    }
};
