<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Armincms\Sofre\Helper; 

class CreateSofreMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Helper::table('menus'), function (Blueprint $table) {
            $table->bigIncrements('id');   
            $table->smallPrice(); 
            $table->integer('duration')->default(1); 
            $table->integer('order')->default(0); 
            $table->boolean('available')->default(true); 
            
            collect(Helper::days())->keys()->each(function($day) use ($table) {
                $table->set($day, array_keys(Helper::meals()))->nullable();
            });

            $table->unsignedBigInteger('food_id')->nullable(); 
            $table->unsignedBigInteger('restaurant_id')->nullable();  

            $table
                ->foreign('food_id')->references('id')
                ->on(Helper::table('food'))
                ->onDelete('cascade')
                ->onUpdate('cascade'); 

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
        Schema::dropIfExists(Helper::table('menus'));
    }
}
