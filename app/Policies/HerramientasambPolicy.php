<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Herramientasamb;
use App\Models\User;

class HerramientasambPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo(permission: 'view-any Herramientasamb');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Herramientasamb $herramientasamb): bool
    {
        return $user->checkPermissionTo('view Herramientasamb');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Herramientasamb');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Herramientasamb $herramientasamb): bool
    {
        return $user->checkPermissionTo('update Herramientasamb');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Herramientasamb $herramientasamb): bool
    {
        return $user->checkPermissionTo('delete Herramientasamb');
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->checkPermissionTo('delete-any Herramientasamb');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Herramientasamb $herramientasamb): bool
    {
        return $user->checkPermissionTo('restore Herramientasamb');
    }

    /**
     * Determine whether the user can restore any models.
     */
    public function restoreAny(User $user): bool
    {
        return $user->checkPermissionTo('restore-any Herramientasamb');
    }

    /**
     * Determine whether the user can replicate the model.
     */
    public function replicate(User $user, Herramientasamb $herramientasamb): bool
    {
        return $user->checkPermissionTo('replicate Herramientasamb');
    }

    /**
     * Determine whether the user can reorder the models.
     */
    public function reorder(User $user): bool
    {
        return $user->checkPermissionTo('reorder Herramientasamb');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Herramientasamb $herramientasamb): bool
    {
        return $user->checkPermissionTo('force-delete Herramientasamb');
    }

    /**
     * Determine whether the user can permanently delete any models.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->checkPermissionTo('force-delete-any Herramientasamb');
    }
}
