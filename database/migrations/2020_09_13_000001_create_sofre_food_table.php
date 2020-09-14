<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Armincms\Sofre\Helper;

class CreateSofreFoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Helper::table('food'), function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->json('name')->nullable(); 
            $table->json('material')->nullable();
            $table->boolean('private')->default(0); 
            $table->auth();   

            $table->unsignedBigInteger('food_group_id')->nullable();  

            $table->softDeletes();
            $table->timestamps(); 

            $table
                ->foreign('food_group_id')->references('id')
                ->on(Helper::table('food_groups'));  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Helper::table('food'));
    }
}
