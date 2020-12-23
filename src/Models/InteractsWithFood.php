<?php

namespace Armincms\Sofre\Models; 

use Armincms\Sofre\Helper;

trait InteractsWithFood
{   
    public function foods()
    {

        return $this->belongsToMany(Food::class, Helper::table('food_restaurant'))
		        	->withPivot(collect(Helper::days())->keys()->merge([
		        		'order', 'available', 'duration', 'price', 'id'
		        	])->all());
    }
}