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
            $table->smallPrice('min_order'); 
            $table->boolean('center')->default(false); 
            $table->unsignedBigInteger('zone_id')->nullable();
            $table->unsignedBigInteger('chain_id')->nullable();
            $table->unsignedBigInteger('restaurant_type_id')->nullable();
            $table->boolean('online')->default(true);
            $table->string('sequence_key')->nullable();
            $table->hits();       
            $table->auth();       
            $table->coordinates();    

            // $table->publication([
            //     'pending', 'approved', 'closed'
            // ]);    
            
            $table->json('contacts')->nullable(); 

            $table->json('working_hours')->nullable()
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
 
            $table->string('name')->nullable();  
            $table->string('locale')->default(app()->getLocale());  
            $table->visiting();  
            $table->string('address')->nullable();
            $table->timestamps();
            $table->softDeletes(); 

            $table
                ->foreign('zone_id')->references('id')
                ->on('locations')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table
                ->foreign('chain_id')->references('id')
                ->on(Helper::table('restaurants'))
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
