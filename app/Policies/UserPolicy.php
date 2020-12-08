<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class UserPolicy
 * @package App\Policies
 *
 */
class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authenticated user can view the information from other users or not.
     *
     * @param  User $user The resource entity from the authenticated user.
     * @return bool
     */
    public function show(User $user): bool
    {
        return $user->hasAnyRole(['administrator', 'webmaster']);
    }

    /**
     * Determine whether the user can create new users in the application or not.
     *
     * @param  User $user The resource entity from the authenticated user.
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['administrator', 'webmaster']);
    }

    /**
     * Determine whether the authenticated user can deactivate other users in the application.
     *
     * @param  User $user   The resource entity from the authenticated user.
     * @param  User $model  The resource entity from the given user.
     * @return bool
     */
    public function deactivate(User $user, User $model): bool
    {
        return $user->isNot($model) && $model->isNotBanned() && $user->hasAnyRole(['administrator', 'webmaster']);
    }

    /**
     * Determine whether the authenticated user can update another user.
     *
     * @param  User $user  The resource entity from the authenticated user.
     * @param  User $model The resource entity  from the given user.
     * @return bool
     */
    public function update(User $user, User $model): bool
    {
        return $user->hasAnyRole(['administrator', 'webmaster']) || $user->is($model);
    }

    /**
     * Determine whether the authenticated user can delete another user.
     *
     * @param  User $user  The resource entity from the authenticated user.
     * @param  User $model The resource entity from the given user.
     * @return bool
     */
    public function delete(User $user, User $model): bool
    {
        return $user->hasAnyRole(['administrator', 'webmaster']) || $user->is($model);
    }
}
