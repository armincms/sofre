<?php

namespace Armincms\Sofre\Policies;
  
use Illuminate\Contracts\Auth\Authenticatable as User; 
use Armincms\Sofre\Restaurant; 

class RestaurantDiscount extends Policy
{ 
    /**
     * Determine whether the user can attach Food to the restaurant.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Armincms\Sofre\Restaurant  $restaurant
     * @return mixed
     */
    public function addRestaurant(User $user, Restaurant $restaurant)
    {
        return $this->authorized();
    }  
}
