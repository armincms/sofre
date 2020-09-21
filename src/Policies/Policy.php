<?php

namespace Armincms\Sofre\Policies;
 
use Illuminate\Contracts\Auth\Authenticatable as User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class Policy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any given models.
     *
     * @param  \Component\Acl\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the given model.
     *
     * @param  \Component\Acl\User  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function view(User $user, Model $model)
    {
        return true;
    }

    /**
     * Determine whether the user can create given models.
     *
     * @param  \Component\Acl\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->authorized();
    }

    /**
     * Determine whether the user can update the given model.
     *
     * @param  \Component\Acl\User  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function update(User $user, Model $model)
    {
        return $this->authorized();
    }

    /**
     * Determine whether the user can delete the given model.
     *
     * @param  \Component\Acl\User  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function delete(User $user, Model $model)
    {
        return $this->authorized();
    }

    /**
     * Determine whether the user can restore the given model.
     *
     * @param  \Component\Acl\User  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function restore(User $user, Model $model)
    {
        return $this->authorized();
    }

    /**
     * Determine whether the user can permanently delete the given model.
     *
     * @param  \Component\Acl\User  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function forceDelete(User $user, Model $model)
    {
        return $this->authorized();
    }

    protected function authorized()
    {
        return \Auth::guard('admin')->check();
    }
}
