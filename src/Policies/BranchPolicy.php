<?php

namespace Armincms\Sofre\Policies;
 
use Illuminate\Contracts\Auth\Authenticatable as User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Armincms\Sofre\Branch;

class BranchPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any branchs.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the branch.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Armincms\Sofre\Branch  $branch
     * @return mixed
     */
    public function view(User $user, Branch $branch)
    {
        return true;
    }

    /**
     * Determine whether the user can create branchs.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the branch.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Armincms\Sofre\Branch  $branch
     * @return mixed
     */
    public function update(User $user, Branch $branch)
    { 
        return \Auth::guard('admin')->check() || $user->is($branch->user);
    }

    /**
     * Determine whether the user can delete the branch.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Armincms\Sofre\Branch  $branch
     * @return mixed
     */
    public function delete(User $user, Branch $branch)
    {
        return \Auth::guard('admin')->check() || $user->is($branch->user);
    }

    /**
     * Determine whether the user can restore the branch.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Armincms\Sofre\Branch  $branch
     * @return mixed
     */
    public function restore(User $user, Branch $branch)
    {
        return \Auth::guard('admin')->check() || $user->is($branch->user);
    }

    /**
     * Determine whether the user can permanently delete the branch.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Armincms\Sofre\Branch  $branch
     * @return mixed
     */
    public function forceDelete(User $user, Branch $branch)
    {
        return \Auth::guard('admin')->check() || $user->is($branch->user);
    }
}
