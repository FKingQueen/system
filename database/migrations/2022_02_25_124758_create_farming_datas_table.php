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
            $table->integer('crop_id');
            $table->integer('farmer_id');
            $table->integer('municipality_id');
            $table->integer('barangay_id');
            $table->boolean('status')->default(0);
            $table->float('lot_size');
            $table->decimal('yield', 8, 2)->nullable();
            $table->decimal('sacks', 8, 2)->nullable();
            $table->decimal('kg', 8, 2)->nullable();
            $table->decimal('unit', 8, 2)->nullable();
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
