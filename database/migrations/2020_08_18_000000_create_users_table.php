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
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('mobile_country_code', 5)->nullable();
            $table->string('mobil_no', 36)->nullable();
            $table->string('user_name', 100)->unique();
            $table->string('image')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('ethnicity')->nullable();
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->unsignedBigInteger('state_id');
            $table->foreign('state_id')->references('id')->on('country_states')->onDelete('cascade');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->string('device_token')->nullable();
            $table->tinyInteger('status')->comment('1=> active , 2 => inactive');
            $table->tinyInteger('notification_status')->comment('1=> active , 0 => inactive');
            $table->tinyInteger('chat_status')->comment('1=> enabled , 0 => disabled');
            $table->tinyInteger('read_notification')->comment('1=> active , 0 => inactive');
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
