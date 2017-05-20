<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupremeServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supreme_servers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->string('ip');
            $table->integer('port');
            $table->nullableTimestamps();

            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supreme_servers');
    }
}
