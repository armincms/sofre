<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Armincms\Sofre\Helper;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Helper::table('branches'), function (Blueprint $table) {
            $table->bigIncrements('id');  
            $table->hits();  
            $table->auth();
            $table->abstract();    
            $table->string('sequence_key')->nullable();
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
        Schema::dropIfExists(Helper::table('branches'));
    }
}
