<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Armincms\Sofre\Helper; 

class CreateSofreOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Helper::table('orders'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('number');
            $table->string('marked_as')->default('pending');
            $table->string('sending_method')->default('courier');
            $table->string('payment_method')->default('online');
            $table->auth(); 
            $table->unsignedBigInteger('invoice_id')->nullable();   
            $table->softDeletes();
            $table->timestamps();   
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Helper::table('orders'));
    }
}
