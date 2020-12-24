<?php

namespace Armincms\Sofre\Models;  

use Armincms\Location\Location;
use Armincms\Location\Concerns\Locatable;


trait InteractsWithAreas
{     
	use Locatable;
 
    /**
     * Alias of the locations.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function areas()
    {
        return $this->belongsToMany(Location::class, 'sofre_areas')->withPivot([
            'cost', 'duration', 'note', 'id'
        ]);
    }

    /**
     * Query the related Location.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function locations()
    {
        return $this->areas();
    }

    /**
     * Return`s average of the courier price.
     * 
     * @return float
     */
    public function averageCourierPrice()
    {
        return floatval($this->areas->average('cost')); 
    }

    /**
     * Return`s max of the courier price.
     * 
     * @return float
     */
    public function maxCourierPrice()
    {
        return floatval($this->areas->max('cost')); 
    }

    /**
     * Return`s min of the courier price.
     * 
     * @return float
     */
    public function minCourierPrice()
    {
        return floatval($this->areas->min('cost')); 
    }

    /**
     * Return`s average of the courier time.
     * 
     * @return float
     */
    public function averageCourierTime()
    {
        return floatval($this->areas->average('duration')); 
    }

    /**
     * Return`s max of the courier time.
     * 
     * @return float
     */
    public function maxCourierTime()
    {
        return floatval($this->areas->max('duration')); 
    }

    /**
     * Return`s min of the courier time.
     * 
     * @return float
     */
    public function minCourierTime()
    {
        return floatval($this->areas->min('duration')); 
    }
}