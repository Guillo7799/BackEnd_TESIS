<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCVitaesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_vitaes', function (Blueprint $table) {
            $table->id();
            $table->string( 'university');
            $table->string( 'career');
            $table->string( 'language');
            $table->string( 'level_language');
            $table->string( 'habilities');
            $table->string( 'certificates');
            $table->string( 'highschool_degree');
            $table->string( 'work_experience');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
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
        Schema::dropIfExists('c_vitaes');
    }
}