<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Armincms\Sofre\Helper;

class CreateSofreRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Helper::table('restaurants'), function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->hits();       
            $table->coordinates();       
            $table->smallPrice('min_order'); 
            $table->boolean('center')->default(false);
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('zone_id')->nullable();
            $table->unsignedBigInteger('restaurant_type_id')->nullable();
            $table->string('marked_as')->default('pending');
            $table->string('sequence_key')->nullable();

            // $table->publication([
            //     'pending', 'approved', 'closed'
            // ]);    
            
            $table->json('contacts')->nullable(); 

            $table->json('sending_method')->nullable()/*->default(json_encode([
                'send',
                'serve',
                'delivery',
                'courier',
            ]))*/;  

            $table->json('payment_method')->nullable()/*->default(json_encode([
                'pos',
                'online',
                'cash',
                'credit',
            ]))*/;  

            $table->description();    
            $table->string('address')->nullable();
            $table->timestamps();

            $table
                ->foreign('branch_id')->references('id')
                ->on(Helper::table('branches'))
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table
                ->foreign('zone_id')->references('id')
                ->on('locations')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table
                ->foreign('restaurant_type_id')->references('id')
                ->on(Helper::table('restaurant_types'))
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
        Schema::dropIfExists(Helper::table('restaurants'));
    }
}
