<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('packagename', 50);
            $table->integer('suborganization_id')->unsigned();
            $table->dateTime('dtcreated')->useCurrent = true;
            $table->integer('totalsession');
            $table->integer('duration');
            $table->date('dtstart');
            $table->date('dtend');
            $table->float('defaultprice');
            $table->integer('active')->default('1');


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
        Schema::dropIfExists('packages');
    }
}
