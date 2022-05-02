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
            $table->integer('status')->default(0);
            $table->decimal('lot_size', 5, 3);
            $table->date('date')->nullable();
            $table->decimal('yield', 8, 2)->nullable();
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
