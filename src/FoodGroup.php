<?php

namespace Armincms\Sofre;  
   

class FoodGroup extends Model  
{ 

    public function foods()
    {
    	return $this->hasMany(Food::class);
    } 
}
