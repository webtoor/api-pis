<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('USER_ROLE', function (Blueprint $table) {
            $table->increments('USERROLEID');
            $table->integer('USERID')->unsigned();
            $table->integer('ROLEID')->unsigned();
            $table->foreign('USERID')->references('USERID')->on('USERS')->onDelete('cascade');
            $table->foreign('ROLEID')->references('ROLEID')->on('RF_ROLES')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_roles');
    }
}
