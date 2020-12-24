<?php

namespace Armincms\Sofre\Models;  

use Illuminate\Database\Eloquent\Collection;

class DiscountCollection extends Collection
{   
    /**
     * Get the price with discount  for the given food.
     * 
     * @param  \Armincms\Sofre\Food $food
     * @return float
     */
    public function applyOn(Food $food)
    {
        $price = floatval(optional($food->pivot)->price); 

        return with(floatval($price - $this->discountAmount($food)), function($price) {
            return $price > 0 ? $price : 0;
        });
    } 

    /**
     * Get the discounted amount for the given food.
     * 
     * @param  \Armincms\Sofre\Food $food
     * @return float
     */
    public function discountAmount(Food $food)
    {
        return $this->sum->discountAmount(floatval(optional($food->pivot)->price));
    }  

    /**
     * Get the discount percentage for the given food.
     * 
     * @param  \Armincms\Sofre\Food $food
     * @return float
     */
    public function discountPercent(Food $food)
    {
        $discountAmount = $this->discountAmount($food);
        $price = floatval(optional($food->pivot)->price); 

        return $discountAmount >= $price ? 100 : ($discountAmount / $price) * 100;
    } 
}
