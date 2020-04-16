<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration; 
use Armincms\Sofre\Helper;

class CreateFoodTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Helper::table('food_translations'), function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->resource();
            $table->json('material')->default('[]');    

            $table->unsignedBigInteger('food_id'); 

            $table
                ->foreign('food_id')->references('id')
                ->on(Helper::table('foods'))
                ->onDelete('cascade')
                ->onUpdate('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Helper::table('food_translations'));
    }
}
