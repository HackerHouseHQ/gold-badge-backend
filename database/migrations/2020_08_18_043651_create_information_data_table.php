<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformationDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('information_data', function (Blueprint $table) {
            $table->id();
            $table->text('about_us')->nullable();
            $table->text('privacy')->nullable();
            $table->text('terms')->nullable();
            // $table->boolean('terms')->comment('1=>yes, 0=>no');
            // $table->boolean('approval')->nullable();
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
        Schema::dropIfExists('information_data');
    }
}
