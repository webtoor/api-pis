<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSuborganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_suborganizations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('suborganization_id')->unsigned();
            $table->dateTime('dtjoined')->useCurrent = true;
            $table->integer('active')->default('1');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('suborganization_id')->references('id')->on('suborganizations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_suborganizations');
    }
}
