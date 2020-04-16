<?php

namespace Armincms\Sofre\Policies;

use Illuminate\Contracts\Auth\Authenticatable as User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Armincms\Sofre\FoodGroup;

class FoodGroupPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any foodGroups.
     *
     * @param  \Component\Acl\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the foodGroup.
     *
     * @param  \Component\Acl\User  $user
     * @param  \Armincms\Sofre\FoodGroup  $foodGroup
     * @return mixed
     */
    public function view(User $user, FoodGroup $foodGroup)
    {
        return true;
    }

    /**
     * Determine whether the user can create foodGroups.
     *
     * @param  \Component\Acl\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the foodGroup.
     *
     * @param  \Component\Acl\User  $user
     * @param  \Armincms\Sofre\FoodGroup  $foodGroup
     * @return mixed
     */
    public function update(User $user, FoodGroup $foodGroup)
    { 
        return \Auth::guard('admin')->check() || $user->is($foodGroup->user);
    }

    /**
     * Determine whether the user can delete the foodGroup.
     *
     * @param  \Component\Acl\User  $user
     * @param  \Armincms\Sofre\FoodGroup  $foodGroup
     * @return mixed
     */
    public function delete(User $user, FoodGroup $foodGroup)
    {
        return \Auth::guard('admin')->check() || $user->is($foodGroup->user);
    }

    /**
     * Determine whether the user can restore the foodGroup.
     *
     * @param  \Component\Acl\User  $user
     * @param  \Armincms\Sofre\FoodGroup  $foodGroup
     * @return mixed
     */
    public function restore(User $user, FoodGroup $foodGroup)
    {
        return \Auth::guard('admin')->check() || $user->is($foodGroup->user);
    }

    /**
     * Determine whether the user can permanently delete the foodGroup.
     *
     * @param  \Component\Acl\User  $user
     * @param  \Armincms\Sofre\FoodGroup  $foodGroup
     * @return mixed
     */
    public function forceDelete(User $user, FoodGroup $foodGroup)
    {
        return \Auth::guard('admin')->check() || $user->is($foodGroup->user);
    }
}
