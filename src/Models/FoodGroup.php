<?php

namespace Armincms\Sofre\Models;  
   

class FoodGroup extends Model  
{   
    /**
     * The `foods` relationship.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function foods()
    {
    	return $this->hasMany(Food::class);
    } 
}
