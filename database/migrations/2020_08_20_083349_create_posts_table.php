<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->unsignedBigInteger('badge_id')->nullable();
            $table->foreign('badge_id')->references('id')->on('department_badges')->onDelete('cascade');
            $table->integer('reason_id')->nullable();
            $table->integer('rating')->nullable();
            $table->text('comment')->nullable();
            $table->tinyInteger('stay_anonymous')->default(0);
            $table->tinyInteger('flag')->default(0)->comment('1 => departments 2 => badges');
            $table->tinyInteger('user_rating');
            $table->tinyInteger('consider_rating')->default(1)->comment('0 => not consider  , 1 => consider rating');
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
        Schema::dropIfExists('posts');
    }
}
