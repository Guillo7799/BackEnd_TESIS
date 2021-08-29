<?php

namespace App\Policies;

use App\Models\CVitae;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CVitaePolicy
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
        return $user->isGranted(User::ROLE_BUSINESS);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CVitae  $cVitae
     * @return mixed
     */
    public function view(User $user, CVitae $cVitae)
    {
        return $user->isGranted(User::ROLE_STUDENT);
    }

    public function viewCVitaeUser(User $user, CVitae $cVitae)
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
     * @param  \App\Models\CVitae  $cVitae
     * @return mixed
     */
    public function update(User $user, CVitae $cVitae)
    {
        return $user->isGranted(User::ROLE_STUDENT);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CVitae  $cVitae
     * @return mixed
     */
    public function delete(User $user, CVitae $cVitae)
    {
        return $user->isGranted(User::ROLE_STUDENT);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CVitae  $cVitae
     * @return mixed
     */
    public function restore(User $user, CVitae $cVitae)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CVitae  $cVitae
     * @return mixed
     */
    public function forceDelete(User $user, CVitae $cVitae)
    {
        //
    }
}