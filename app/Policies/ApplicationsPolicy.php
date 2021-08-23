<?php

namespace App\Policies;

use App\Models\Applications;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationsPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isGranted(User::ROLE_SUPERADMIN)) {
        return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isGranted(User::ROLE_STUDENT);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Applications  $applications
     * @return mixed
     */
    public function view(User $user, Applications $applications)
    {
        return $user->isGranted(User::ROLE_STUDENT);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isGranted(User::ROLE_STUDENT);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Applications  $applications
     * @return mixed
     */
    public function update(User $user, Applications $applications)
    {
        return $user->isGranted(User::ROLE_BUSINESS);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Applications  $applications
     * @return mixed
     */
    public function delete(User $user, Applications $applications)
    {
        return $user->isGranted(User::ROLE_SUPERADMIN);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Applications  $applications
     * @return mixed
     */
    public function restore(User $user, Applications $applications)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Applications  $applications
     * @return mixed
     */
    public function forceDelete(User $user, Applications $applications)
    {
        //
    }
}