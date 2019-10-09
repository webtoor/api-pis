<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuborganizationContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suborganization_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('suborganization_id')->unsigned();
            $table->integer('pic')->unsigned();
            $table->integer('contacttype_id')->unsigned();
            $table->string('contactvalue', 150);
            $table->date('dtstart');
            $table->integer('active')->default('1');


            $table->foreign('suborganization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('pic')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('contacttype_id')->references('id')->on('rf_contacts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suborganization_contacts');
    }
}
