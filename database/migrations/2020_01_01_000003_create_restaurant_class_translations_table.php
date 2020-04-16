<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Armincms\Sofre\Helper;

class CreateRestaurantClassTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Helper::table('restaurant_class_translations'), function (Blueprint $table) { 
            $table->bigIncrements('id'); 
            $table->abstract(); 
            $table->unsignedBigInteger('restaurant_class_id'); 

            $table
                ->foreign('restaurant_class_id', Helper::table('rc_foreign_id'))
                ->references('id')->on(Helper::table('restaurant_classes'))
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
        Schema::dropIfExists(Helper::table('restaurant_class_translations'));
    }
}
