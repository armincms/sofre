<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Armincms\Sofre\Helper; 

class ChangeSofreRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Helper::table('restaurants'), function (Blueprint $table) {
            $table->price('packaging_cost');       
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Helper::table('restaurants'), function (Blueprint $table) {
            $table->dropColumn(['packaging_cost']);     
        });
    }
}
