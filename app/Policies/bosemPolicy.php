<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\bosem;
use App\Models\User;

class bosemPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any bosem');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, bosem $bosem): bool
    {
        return $user->checkPermissionTo('view bosem');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create bosem');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, bosem $bosem): bool
    {
        return $user->checkPermissionTo('update bosem');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, bosem $bosem): bool
    {
        return $user->checkPermissionTo('delete bosem');
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->checkPermissionTo('delete-any bosem');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, bosem $bosem): bool
    {
        return $user->checkPermissionTo('restore bosem');
    }

    /**
     * Determine whether the user can restore any models.
     */
    public function restoreAny(User $user): bool
    {
        return $user->checkPermissionTo('restore-any bosem');
    }

    /**
     * Determine whether the user can replicate the model.
     */
    public function replicate(User $user, bosem $bosem): bool
    {
        return $user->checkPermissionTo('replicate bosem');
    }

    /**
     * Determine whether the user can reorder the models.
     */
    public function reorder(User $user): bool
    {
        return $user->checkPermissionTo('reorder bosem');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, bosem $bosem): bool
    {
        return $user->checkPermissionTo('force-delete bosem');
    }

    /**
     * Determine whether the user can permanently delete any models.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->checkPermissionTo('force-delete-any bosem');
    }
}
