<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupremeServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supreme_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('agent');
            $table->string('name');
            $table->string('slug');
            $table->string('type');
            $table->nullableTimestamps();

            $table->unique(['slug']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supreme_services');
    }
}
