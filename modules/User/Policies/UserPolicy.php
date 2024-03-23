<?php

declare(strict_types=1);

namespace Modules\User\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Entities\V1\User;

class UserPolicy
{
    use HandlesAuthorization;

    public static string $entity = User::class;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_user');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param User $userModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, User $userModel): bool
    {
        return $user->can('view_user');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user): bool
    {
        return $user->can('create_user');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param User $userModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $userModel): bool
    {
        return $user->can('update_user');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param User $userModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $userModel): bool
    {
        return $user->can('delete_user');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_user');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param User $user
     * @param User $userModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, User $userModel): bool
    {
        return $user->can('{{ ForceDelete }}');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('{{ ForceDeleteAny }}');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param User $user
     * @param User $userModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, User $userModel): bool
    {
        return $user->can('restore_user');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_user');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param User $user
     * @param User $userModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function replicate(User $user, User $userModel): bool
    {
        return $user->can('{{ Replicate }}');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function reorder(User $user): bool
    {
        return $user->can('{{ Reorder }}');
    }

}
