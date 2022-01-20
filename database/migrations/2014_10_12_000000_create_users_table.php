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
            $table->string('married_name', 25)->nullable();
            $table->string('avatar')->nullable();
            $table->string('email')->unique();
            $table->string('phone1', 25)->nullable();
            $table->string('phone2', 25)->nullable();
            $table->enum('gender', ['M', 'F'])->nullable();
            $table->enum('civil', ['Single', 'Married'])->nullable();
            $table->string('birth', 25)->nullable();
            $table->string('patient_code', 25)->nullable();
            $table->enum('document_type', ['No document','ID number', 'Passport'])->nullable();
            $table->string('document', 25)->nullable();
            $table->enum('status', ['Active', 'Disabled'])->default('Active')->nullable();
            $table->string('name_relation', 50)->nullable();
            $table->enum('kinship', ['No responsible','Spouse', 'Mother','Father', 'Partner','Son or Daughter', 'Aunt or Uncle','Cousin','Other'])->nullable();
            $table->text('address')->nullable();
            $table->string('password');
            $table->unsignedMediumInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->unsignedMediumInteger('state_id');
            $table->foreign('state_id')->references('id')->on('states');
            $table->unsignedMediumInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->unsignedBigInteger('setting_id')->nullable();
            $table->foreign('setting_id')->references('id')->on('settings');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->softDeletes();
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
