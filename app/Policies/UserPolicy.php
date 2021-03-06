<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Application;
use App\Models\CVitae;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
    public function viewUserPublications(User $user)
    {
        return $user->isGranted(User::ROLE_BUSINESS);
    }
    public function deleteUserPublications(User $user)
    {
        return $user->isGranted(User::ROLE_BUSINESS);
    }
    public function viewUserCurriculum(User $user)
    {
        return $user->isGranted(User::ROLE_STUDENT);
    }
    public function updateUserCurriculum(User $user, CVitae $model)
    {
        return $user->isGranted(User::ROLE_STUDENT) && $user->id === $model->user_id;
    }
    public function viewUserApplication(User $user)
    {
        return $user->isGranted(User::ROLE_STUDENT);
    }
    public function viewApplicationPublicationUser(User $user)
    {
        return $user->isGranted(User::ROLE_BUSINESS);
    }
    public function updateApplicationPublication(User $user)
    {
        return $user->isGranted(User::ROLE_BUSINESS);
    }
    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function view(User $user, User $model)
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
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return true;
    }
    public function updateBusiness(User $user, User $model)
    {
        return $user->isGranted(User::ROLE_BUSINESS);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        return $user->isGranted(User::ROLE_SUPERADMIN);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }
}