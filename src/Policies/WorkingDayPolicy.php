<?php

namespace Armincms\Sofre\Policies;
 
use Illuminate\Contracts\Auth\Authenticatable as User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Armincms\Sofre\WorkingDay;

class WorkingDayPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any restaurants.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the restaurant.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Armincms\Sofre\WorkingDay  $restaurant
     * @return mixed
     */
    public function view(User $user, WorkingDay $restaurant)
    {
        return false;
    }

    /**
     * Determine whether the user can create restaurants.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the restaurant.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Armincms\Sofre\WorkingDay  $restaurant
     * @return mixed
     */
    public function update(User $user, WorkingDay $restaurant)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the restaurant.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Armincms\Sofre\WorkingDay  $restaurant
     * @return mixed
     */
    public function delete(User $user, WorkingDay $restaurant)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the restaurant.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Armincms\Sofre\WorkingDay  $restaurant
     * @return mixed
     */
    public function restore(User $user, WorkingDay $restaurant)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the restaurant.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Armincms\Sofre\WorkingDay  $restaurant
     * @return mixed
     */
    public function forceDelete(User $user, WorkingDay $restaurant)
    {
        return false;
    } 
}