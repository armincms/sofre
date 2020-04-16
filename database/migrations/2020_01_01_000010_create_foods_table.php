<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Armincms\Sofre\Helper;

class CreateFoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Helper::table('foods'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->discount('discount'); 
            $table->price(); 
            $table->integer('duration')->default(0)->unsigned(); 
            $table->string('currency')->default('IRR'); 
            $table->auth();  

            $table->unsignedBigInteger('food_group_id')->nullable(); 
            $table->unsignedBigInteger('restaurant_id')->nullable(); 

            $table->softDeletes();
            $table->timestamps();

            $table
                ->foreign('food_group_id')->references('id')
                ->on(Helper::table('food_groups'))
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
        Schema::dropIfExists(Helper::table('foods'));
    }
}
