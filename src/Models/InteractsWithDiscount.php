<?php

namespace Armincms\Sofre\Models;  
 
trait InteractsWithDiscount
{  
    /**
     * Query the related Discount.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }

    /**
     * Return`s perecentage of average discount.
     * 
     * @return float
     */
    public function averageDiscount()
    {
        return $this->foods->average(function($food) {
            return $this->discounts->discountPercent($food);
        }); 
    }

    /**
     * Returns the foods average price.
     * 
     * @return float
     */
    public function averageAmount()
    {  
        return $this->foods->averageAmount();
    }
}
