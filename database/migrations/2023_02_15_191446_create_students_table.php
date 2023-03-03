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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('otp');
            $table->unsignedBigInteger('user_id');
            $table->double('phone');
            $table->unsignedBigInteger('college_id')->nullable();
            $table->unsignedBigInteger('sem_id')->nullable();
            $table->text('image')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('college_id')->references('id')->on('colleges');
            $table->foreign('sem_id')->references('id')->on('semesters');
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
        Schema::dropIfExists('students');
    }
};
