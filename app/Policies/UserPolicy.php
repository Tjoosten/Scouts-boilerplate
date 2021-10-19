<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function show(User $user): bool
    {
        return $user->hasAnyRole(['administrator', 'webmaster']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['administrator', 'webmaster']);
    }

    public function deactivate(User $user, User $model): bool
    {
        return $user->isNot($model) && $model->isNotBanned() && $user->hasAnyRole(['administrator', 'webmaster']);
    }

    public function activate(User $user, User $model): bool
    {
        return $model->isBanned() && $user->isNot($model) && $user->hasAnyRole(['administrator', 'webmaster']);
    }

    public function update(User $user, User $model): bool
    {
        return $user->hasAnyRole(['administrator', 'webmaster']) || $user->is($model);
    }

    public function delete(User $user, User $model): bool
    {
        return $user->hasAnyRole(['administrator', 'webmaster']) || $user->is($model);
    }
}
