<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupremeServerServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supreme_server_services', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('server_id');
            $table->unsignedInteger('services_id');
            $table->nullableTimestamps();

            $table->foreign('server_id')
                  ->references('id')
                  ->on('supreme_servers')
                  ->onDelete('cascade');

            $table->foreign('services_id')
                  ->references('id')
                  ->on('supreme_services')
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
        Schema::dropIfExists('supreme_server_services');
    }
}
