<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Armincms\Sofre\Helper;

class CreateFoodGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Helper::table('food_groups'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->auth();
            $table->resource();
            $table->string('sequence_key')->nullable();
            $table->timestamps();  
            $table->softDeletes(); 

            $table
                ->foreign('sequence_key')->references('sequence_key')
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
        Schema::dropIfExists(Helper::table('food_groups'));
    }
}
