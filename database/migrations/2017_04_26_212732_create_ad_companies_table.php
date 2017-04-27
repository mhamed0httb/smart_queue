<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('service_category');
            $table->string('email');
            $table->string('address');
            $table->text('image')->nullable();
            $table->integer('responsible_id');
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
        Schema::dropIfExists('ad_companies');
    }
}
