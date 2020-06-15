
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration; 
use Armincms\Sofre\Helper; 

class CreateRestaurantFoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Helper::table('restaurant_food'), function (Blueprint $table) {
            $table->bigIncrements('id'); 

            collect(Helper::days())->keys()->each(function($day) use ($table) {
                $table->json($day)->default('[]');
            });

            $table->integer('order')->default(time()); 
            $table->boolean('available')->default(0); 

            $table->unsignedBigInteger('food_id')->nullable(); 
            $table->unsignedBigInteger('restaurant_id')->nullable();  

            $table
                ->foreign('food_id')->references('id')
                ->on(Helper::table('foods'))
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
        Schema::dropIfExists(Helper::table('restaurant_food'));
    }
}
