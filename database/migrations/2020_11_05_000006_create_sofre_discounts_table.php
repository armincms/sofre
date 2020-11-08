<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Armincms\Sofre\Helper; 

class CreateSofreDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Helper::table('discounts'), function (Blueprint $table) {
            $table->bigIncrements('id');    
            $table->string('note')->nullable();
            $table->json('discount'); 
            $table->json('items')->nullable();
            $table->unsignedBigInteger('restaurant_id');  
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_on')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->auth();

            $table
                ->foreign('restaurant_id')->references('id')
                ->on(Helper::table('restaurants'));  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Helper::table('discounts'));
    }
}
