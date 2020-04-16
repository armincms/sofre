<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Armincms\Sofre\Helper;

class CreateRestaurantTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Helper::table('restaurant_translations'), function (Blueprint $table) { 
            $table->bigIncrements('id');
            $table->description();   
            $table->unsignedBigInteger('restaurant_id');
            $table->string('address')->nullable();

            $table
                ->foreign('restaurant_id')->references('id')
                ->on(Helper::table('restaurants'))
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
        Schema::dropIfExists(Helper::table('restaurant_translations'));
    }
}
