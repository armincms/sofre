<?php

namespace Armincms\Sofre\Policies;
 
use Illuminate\Contracts\Auth\Authenticatable as User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Armincms\Sofre\Restaurant;

class RestaurantPolicy
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
     * @param  \Armincms\Sofre\Restaurant  $restaurant
     * @return mixed
     */
    public function view(User $user, Restaurant $restaurant)
    {
        return \Auth::guard('admin')->check() || $user->is($restaurant->user);
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
     * @param  \Armincms\Sofre\Restaurant  $restaurant
     * @return mixed
     */
    public function update(User $user, Restaurant $restaurant)
    {
        return \Auth::guard('admin')->check() || $user->is($restaurant->user);
    }

    /**
     * Determine whether the user can delete the restaurant.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Armincms\Sofre\Restaurant  $restaurant
     * @return mixed
     */
    public function delete(User $user, Restaurant $restaurant)
    {
        return \Auth::guard('admin')->check() || $user->is($restaurant->user);
    }

    /**
     * Determine whether the user can restore the restaurant.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Armincms\Sofre\Restaurant  $restaurant
     * @return mixed
     */
    public function restore(User $user, Restaurant $restaurant)
    {
        return \Auth::guard('admin')->check() || $user->is($restaurant->user);
    }

    /**
     * Determine whether the user can permanently delete the restaurant.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Armincms\Sofre\Restaurant  $restaurant
     * @return mixed
     */
    public function forceDelete(User $user, Restaurant $restaurant)
    {
        return \Auth::guard('admin')->check() || $user->is($restaurant->user);
    }

    /**
     * Determine whether the user can detach WorkingDay from the restaurant.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Armincms\Sofre\Restaurant  $restaurant
     * @return mixed
     */
    public function detachWorkingDay()
    {
        return false;
    } 
}
