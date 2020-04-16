<?php

namespace Armincms\Sofre\Policies;
 
use Illuminate\Contracts\Auth\Authenticatable as User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Armincms\Sofre\Food;

class FoodPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any foods.
     *
     * @param  \Component\Acl\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the food.
     *
     * @param  \Component\Acl\User  $user
     * @param  \Armincms\Sofre\Food  $food
     * @return mixed
     */
    public function view(User $user, Food $food)
    {
        return true;
    }

    /**
     * Determine whether the user can create foods.
     *
     * @param  \Component\Acl\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the food.
     *
     * @param  \Component\Acl\User  $user
     * @param  \Armincms\Sofre\Food  $food
     * @return mixed
     */
    public function update(User $user, Food $food)
    { 
        return \Auth::guard('admin')->check() || $user->is($food->user);
    }

    /**
     * Determine whether the user can delete the food.
     *
     * @param  \Component\Acl\User  $user
     * @param  \Armincms\Sofre\Food  $food
     * @return mixed
     */
    public function delete(User $user, Food $food)
    {
        return \Auth::guard('admin')->check() || $user->is($food->user);
    }

    /**
     * Determine whether the user can restore the food.
     *
     * @param  \Component\Acl\User  $user
     * @param  \Armincms\Sofre\Food  $food
     * @return mixed
     */
    public function restore(User $user, Food $food)
    {
        return \Auth::guard('admin')->check() || $user->is($food->user);
    }

    /**
     * Determine whether the user can permanently delete the food.
     *
     * @param  \Component\Acl\User  $user
     * @param  \Armincms\Sofre\Food  $food
     * @return mixed
     */
    public function forceDelete(User $user, Food $food)
    {
        return \Auth::guard('admin')->check() || $user->is($food->user);
    }
}
