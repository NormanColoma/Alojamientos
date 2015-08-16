<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('surname', 75)->nulleable();
            $table->string('email', 100)->unique();
            $table->string('password', 100);
            $table->rememberToken();
            $table->string('phone', 9)->nulleable();
            $table->boolean('owner')->nulleable();
            $table->boolean('admin')->nulleable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
