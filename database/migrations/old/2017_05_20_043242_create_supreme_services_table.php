<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->unsignedInteger('agent_id');
            $table->unsignedInteger('server_id');
            $table->string('name');
            $table->string('slug');
            $table->string('type');
            $table->nullableTimestamps();
            $table->unique(['slug']);

            $table->foreign('agent_id')
                  ->references('id')
                  ->on('droplets')
                  ->onDelete('cascade');

            $table->foreign('server_id')
                  ->references('id')
                  ->on('supreme_servers')
                  ->onDelete('cascade');
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
