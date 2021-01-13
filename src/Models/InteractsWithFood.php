<?php

namespace Armincms\Sofre\Models; 

use Armincms\Sofre\Helper;

trait InteractsWithFood
{   
	/**
	 * Query the related Food.
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
    public function foods()
    { 
        return $this->belongsToMany(Food::class, Helper::table('menus'))
		        	->withPivot($this->getPivotColumns())
                    ->using(Menu::class);
    }

    /**
     * Returns array of the pivot columns.
     * 
     * @param  string $value 
     * @return array        
     */
    public function getPivotColumns($value='')
    {
    	return array_merge(array_keys(Helper::days()), [
    		'order', 'available', 'duration', 'price', 'id'
    	]); 
    }
}