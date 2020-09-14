<?php

namespace Armincms\Sofre\Policies;
 
use Illuminate\Contracts\Auth\Authenticatable as User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Armincms\Sofre\RestaurantType;

class RestaurantTypePolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any restaurant classes.
     *
     * @param  \Component\Acl\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the restaurant class.
     *
     * @param  \Component\Acl\User  $user
     * @param  \Armincms\Sofre\RestaurantType  $restaurant class
     * @return mixed
     */
    public function view(User $user, RestaurantType $restaurantType)
    {
        return true;
    }

    /**
     * Determine whether the user can create restaurant classes.
     *
     * @param  \Component\Acl\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return \Auth::guard('admin')->check();
    }

    /**
     * Determine whether the user can update the restaurant class.
     *
     * @param  \Component\Acl\User  $user
     * @param  \Armincms\Sofre\RestaurantType  $restaurant class
     * @return mixed
     */
    public function update(User $user, RestaurantType $restaurantType)
    {
        return \Auth::guard('admin')->check();
    }

    /**
     * Determine whether the user can delete the restaurant class.
     *
     * @param  \Component\Acl\User  $user
     * @param  \Armincms\Sofre\RestaurantType  $restaurant class
     * @return mixed
     */
    public function delete(User $user, RestaurantType $restaurantType)
    {
        return \Auth::guard('admin')->check();
    }

    /**
     * Determine whether the user can restore the restaurant class.
     *
     * @param  \Component\Acl\User  $user
     * @param  \Armincms\Sofre\RestaurantType  $restaurant class
     * @return mixed
     */
    public function restore(User $user, RestaurantType $restaurantType)
    {
        return \Auth::guard('admin')->check();
    }

    /**
     * Determine whether the user can permanently delete the restaurant class.
     *
     * @param  \Component\Acl\User  $user
     * @param  \Armincms\Sofre\RestaurantType  $restaurant class
     * @return mixed
     */
    public function forceDelete(User $user, RestaurantType $restaurantType)
    {
        return \Auth::guard('admin')->check();
    }
}
