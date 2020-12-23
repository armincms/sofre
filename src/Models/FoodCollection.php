<?php

namespace Armincms\Sofre\Models; 

use Illuminate\Database\Eloquent\Collection;

class FoodCollection extends Collection  
{    
    /**
     * Return`s average value of the food prices.
     * 
     * @return float
     */
    public function averageAmount()
    {
        return floatval($this->average('pivot.price'));
    }

    /**
     * Return`s max value of the food prices.
     * 
     * @return float
     */
    public function maxAmount()
    {
        return floatval($this->max('pivot.price'));
    }

    /**
     * Return`s min value of the food prices.
     * 
     * @return float
     */
    public function minAmount()
    {
        return floatval($this->min('pivot.price'));
    }
}
