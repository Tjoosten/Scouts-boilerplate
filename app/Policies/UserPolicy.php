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
