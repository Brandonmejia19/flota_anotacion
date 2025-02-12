<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\ListaChequeo;
use App\Models\User;

class ListaChequeoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any ListaChequeo');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ListaChequeo $listachequeo): bool
    {
        return $user->checkPermissionTo('view ListaChequeo');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create ListaChequeo');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ListaChequeo $listachequeo): bool
    {
        return $user->checkPermissionTo('update ListaChequeo');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ListaChequeo $listachequeo): bool
    {
        return $user->checkPermissionTo('delete ListaChequeo');
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->checkPermissionTo('delete-any ListaChequeo');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ListaChequeo $listachequeo): bool
    {
        return $user->checkPermissionTo('restore ListaChequeo');
    }

    /**
     * Determine whether the user can restore any models.
     */
    public function restoreAny(User $user): bool
    {
        return $user->checkPermissionTo('restore-any ListaChequeo');
    }

    /**
     * Determine whether the user can replicate the model.
     */
    public function replicate(User $user, ListaChequeo $listachequeo): bool
    {
        return $user->checkPermissionTo('replicate ListaChequeo');
    }

    /**
     * Determine whether the user can reorder the models.
     */
    public function reorder(User $user): bool
    {
        return $user->checkPermissionTo('reorder ListaChequeo');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ListaChequeo $listachequeo): bool
    {
        return $user->checkPermissionTo('force-delete ListaChequeo');
    }

    /**
     * Determine whether the user can permanently delete any models.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->checkPermissionTo('force-delete-any ListaChequeo');
    }
}
