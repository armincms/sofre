<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Armincms\Sofre\Helper;

class CreateBranchTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Helper::table('branch_translations'), function (Blueprint $table) { 
            $table->bigIncrements('id');
            $table->abstract();    
            $table->unsignedBigInteger('branch_id');

            $table
                ->foreign('branch_id')->references('id')
                ->on(Helper::table('branches'))
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
        Schema::dropIfExists(Helper::table('branch_translations'));
    }
}
