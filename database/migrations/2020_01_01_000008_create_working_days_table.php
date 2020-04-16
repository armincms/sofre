
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Armincms\Sofre\WorkingDay;
use Armincms\Sofre\Helper;

class CreateWorkingDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Helper::table('working_days'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('day');   
        });

        WorkingDay::insert(
            collect(Helper::days())->map(function($label, $day) {
                return compact('day');
            })->values()->toArray()
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Helper::table('working_days'));
    }
}
