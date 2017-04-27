<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdPlanningTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_planning', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ad_id');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('status');
            $table->integer('office_id');
            $table->integer('nbr_shown');
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
        Schema::dropIfExists('ad_planning');
    }
}
