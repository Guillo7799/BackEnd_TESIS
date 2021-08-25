<?php

namespace App\Policies;

use App\Models\Publication;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PublicationPolicy
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
    
    public function viewPublicationUser(User $user)
    {
        return $user->isGranted(User::ROLE_BUSINESS);
    }

    public function deletePublicationUser(User $user)
    {
        return $user->isGranted(User::ROLE_BUSINESS);
    }

    public function viewApplicationPublication(User $user)
    {
        return $user->isGranted(User::ROLE_STUDENT); 
    }
    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Publication  $publication
     * @return mixed
     */
    public function view(User $user, Publication $publication)
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
        return $user->isGranted(User::ROLE_BUSINESS);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Publication  $publication
     * @return mixed
     */
    public function update(User $user, Publication $publication)
    {
        return $user->isGranted(User::ROLE_STUDENT) && $user->id === $publication->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Publication  $publication
     * @return mixed
     */
    public function delete(User $user, Publication $publication)
    {
        return $user->isGranted(User::ROLE_BUSINESS);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Publication  $publication
     * @return mixed
     */
    public function restore(User $user, Publication $publication)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Publication  $publication
     * @return mixed
     */
    public function forceDelete(User $user, Publication $publication)
    {
        //
    }
}