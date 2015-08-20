<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccommodationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 50);
            $table->string('desc');
            $table->integer('capacity');
            $table->integer('beds');
            $table->integer('bathrooms');
            $table->string('inside', 1000);
            $table->string('outside', 1000);
            $table->decimal('price_per_person',6,2);
            $table->string('city', 100);
            $table->string('province',100);
            $table->integer('user_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('accommodations');
    }
}
