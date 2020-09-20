
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration; 
use Armincms\Sofre\Restaurant;
use Armincms\Sofre\Helper;

class CreateSofreRestaurantWorkingDayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Helper::table('restaurant_working_day'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('note')->nullable();  

            collect(Helper::meals())->keys()->each([$table, 'json']);

            $table->unsignedBigInteger('working_day_id');
            $table->unsignedBigInteger('restaurant_id');

            $table->foreign('working_day_id')->references('id')
                ->on(Helper::table('working_days'))
                ->onDelete('cascade')
                ->onUpdate('cascade');  

            $table->foreign('restaurant_id')->references('id')
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
        Schema::dropIfExists(Helper::table('restaurant_working_day'));
    }
}
