<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('USERS', function (Blueprint $table) {
            $table->increments('USERID', 11);
            $table->string('USERNAME', 50);
            $table->string('PASSWORD');
            $table->string('FIRSTNAME',50);
            $table->string('MIDDLENAME',50);
            $table->string('LASTNAME',50);
            $table->string('EMAIL')->unique();
            $table->date('DOB');
            $table->tinyinteger('SEX');
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
        Schema::dropIfExists('USERS');
    }
}
