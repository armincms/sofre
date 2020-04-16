<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Armincms\Sofre\Helper;

class CreateFoodGroupTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Helper::table('food_group_translations'), function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->resource();

            $table->unsignedBigInteger('food_group_id');  

            $table
                ->foreign('food_group_id')->references('id')
                ->on(Helper::table('food_groups'))
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
        Schema::dropIfExists(Helper::table('food_group_translations'));
    }
}
