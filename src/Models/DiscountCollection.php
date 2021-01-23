<?php

namespace Armincms\Sofre\Models;  

use Illuminate\Database\Eloquent\Collection;

class DiscountCollection extends Collection
{   
    /**
     * Get the price with discount  for the given price.
     * 
     * @param  integer price
     * @return float
     */
    public function applyOn($price)
    { 
        return with(floatval($price - $this->discountAmount($price)), function($price) {
            return $price > 0 ? $price : 0;
        });
    } 

    /**
     * Get the discounted amount for the given price.
     * 
     * @param  integer price
     * @return float
     */
    public function discountAmount($price)
    {
        return $this->sum->discountAmount(floatval($price));
    }  

    /**
     * Get the discount percentage for the given price.
     * 
     * @param  integer price
     * @return float
     */
    public function discountPercent($price)
    {
        $discountAmount = $this->discountAmount($price);
        $price = floatval($price); 

        return $discountAmount >= $price ? 100 : ($discountAmount / $price) * 100;
    } 
}
