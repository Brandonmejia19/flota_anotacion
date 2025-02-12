<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Elementosamb;
use App\Models\User;

class ElementosambPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Elementosamb');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Elementosamb $elementosamb): bool
    {
        return $user->checkPermissionTo('view Elementosamb');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Elementosamb');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Elementosamb $elementosamb): bool
    {
        return $user->checkPermissionTo('update Elementosamb');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Elementosamb $elementosamb): bool
    {
        return $user->checkPermissionTo('delete Elementosamb');
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->checkPermissionTo('delete-any Elementosamb');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Elementosamb $elementosamb): bool
    {
        return $user->checkPermissionTo('restore Elementosamb');
    }

    /**
     * Determine whether the user can restore any models.
     */
    public function restoreAny(User $user): bool
    {
        return $user->checkPermissionTo('restore-any Elementosamb');
    }

    /**
     * Determine whether the user can replicate the model.
     */
    public function replicate(User $user, Elementosamb $elementosamb): bool
    {
        return $user->checkPermissionTo('replicate Elementosamb');
    }

    /**
     * Determine whether the user can reorder the models.
     */
    public function reorder(User $user): bool
    {
        return $user->checkPermissionTo('reorder Elementosamb');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Elementosamb $elementosamb): bool
    {
        return $user->checkPermissionTo('force-delete Elementosamb');
    }

    /**
     * Determine whether the user can permanently delete any models.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->checkPermissionTo('force-delete-any Elementosamb');
    }
}
