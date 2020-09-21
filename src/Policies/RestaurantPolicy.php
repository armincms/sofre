<?php

namespace Armincms\Sofre\Policies;
  
use Illuminate\Contracts\Auth\Authenticatable as User;
use Armincms\Sofre\Restaurant;
use Armincms\Sofre\Food;

class RestaurantPolicy extends Policy
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

    /**
     * Determine whether the user can attach Food to the restaurant.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Armincms\Sofre\Food  $restaurant
     * @return mixed
     */
    public function attachFood(User $user, Food $food)
    {
        return $this->authorized();
    } 

    /**
     * Determine whether the user can attach Food from the restaurant.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Armincms\Sofre\Food  $restaurant
     * @return mixed
     */
    public function detachFood(User $user, Food $food)
    {
        return $this->authorized();
    } 
}
