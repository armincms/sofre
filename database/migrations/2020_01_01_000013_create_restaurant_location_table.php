<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Armincms\Sofre\Helper; 

class CreateRestaurantLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Helper::table('restaurant_location'), function (Blueprint $table) {
            $table->bigIncrements('id');   
            $table->smallPrice('cost');
            $table->integer('duration')->default(0);
            $table->string('description', 250)->nullable(); 
            
            $table->unsignedBigInteger('location_id')->nullable(); 
            $table->unsignedBigInteger('restaurant_id')->nullable();  

            $table
                ->foreign('location_id')->references('id')
                ->on('locations')
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
        Schema::dropIfExists(Helper::table('restaurant_location'));
    }
}
