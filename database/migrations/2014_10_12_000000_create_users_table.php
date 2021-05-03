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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name1', 25);
            $table->string('name2', 25)->nullable();
            $table->string('surname1', 25);
            $table->string('surname2', 25)->nullable();
            $table->string('avatar')->nullable();
            $table->string('email')->unique();
            $table->string('phone1', 25)->nullable();
            $table->text('address')->nullable();
            $table->unsignedMediumInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->unsignedMediumInteger('state_id');
            $table->foreign('state_id')->references('id')->on('states');
            $table->unsignedMediumInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
