<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Armincms\Sofre\Helper;

class CreateRestaurantClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Helper::table('restaurant_classes'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->auth();
            $table->hits();
            $table->abstract(); 
            $table->string('sequence_key')->nullable();
            $table->timestamps();  
            $table->softDeletes(); 

            $table
                ->foreign('sequence_key')->references('sequence_key')
                ->on(Helper::table('restaurant_classes'))
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
        Schema::dropIfExists(Helper::table('restaurant_classes'));
    }
}
