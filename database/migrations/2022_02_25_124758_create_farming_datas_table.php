<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFarmingDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farming_datas', function (Blueprint $table) {
            $table->id();
            $table->integer('cropping_season_id');
            $table->string('crop_id');
            $table->integer('lot_size');
            $table->integer('status');
            $table->integer('yield');
            $table->integer('unit');
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
        Schema::dropIfExists('farming_datas');
    }
}
