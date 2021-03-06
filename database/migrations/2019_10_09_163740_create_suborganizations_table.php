<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuborganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suborganizations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('suborganizationname', 100);
            $table->integer('organization_id')->unsigned();
            $table->dateTime('dtjoined')->useCurrent = true;
            $table->integer('active')->default('1');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suborganizations');
    }
}
