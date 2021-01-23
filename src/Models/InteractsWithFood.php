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
        return $this->belongsToMany(Food::class, Helper::table('menu'))
		        	->withPivot($this->getPivotColumns())
                    ->using(Menu::class);
    }

    /**
     * Query the related Food.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function menus()
    { 
        return $this->hasMany(Menu::class);
    } 

    /**
     * Returns array of the pivot columns.
     * 
     * @param  string $value 
     * @return array        
     */
    public function getPivotColumns()
    {
    	return array_merge(array_keys(Helper::days()), [
    		'order', 'available', 'duration', 'price', 'id'
    	]); 
    }

    /**
     * Order given query by the sum rating.
     * 
     * @param  \Illuminate\Database\Eloqeunt\Builder $query
     * @param  string $direction
     * @return \Illuminate\Database\Eloqeunt\Builder       
     */
    public function scopeOrderByMenuRating($query, string $direction = 'asc')
    {    
        if (is_null($query->getQuery()->columns)) {
            $query->select([$query->qualifyColumn('*')]);
        }

        return $query->selectSub($this->ratingQuery(), 'rating')->orderBy('rating', $direction);
    }

    /**
     * Returns query for the rating sum.
     * 
     * @return \Illuminate\Database\Eloqeunt\Builder   
     */
    public function ratingQuery()
    {
        $joinCallback = function($join) { 
            $menu = new Menu;

            $join->on($menu->ratings()->getModel()->qualifyColumn('rateable_id'), '=', $menu->getQualifiedKeyName())
                ->whereRateableType($menu->getMorphClass())
                ->whereColumn($this->getQualifiedKeyName(), $menu->qualifyColumn('restaurant_id'));
        };

        return Menu::query()
                ->selectRaw('sum(rating)')
                ->leftJoin('ratings', $joinCallback)  
                ->getQuery(); 
    }

}