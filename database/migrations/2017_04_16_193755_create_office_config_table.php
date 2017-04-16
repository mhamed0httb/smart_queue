<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficeConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('office_config', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('office_id');
            $table->string('opening_time_morning')->nullable();
            $table->string('closing_time_morning')->nullable();
            $table->string('opening_time_evening')->nullable();
            $table->string('closing_time_evening')->nullable();
            $table->integer('capacity')->nullable();
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
        Schema::dropIfExists('office_config');
    }
}
