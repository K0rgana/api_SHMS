<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicoes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('sensor_id')->foreign('sensor_id')->references('id')->on('sensores')->onDelete('cascade');
            $table->integer('valor');
            $table->datetime('data_horario');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicoes');
    }
}
