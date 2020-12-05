<?php

namespace App\Actions\Users;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\Pure;

/**
 * Class UpdateUserAction
 *
 * @package App\Actions\Users
 */
class UpdateUserAction
{
    /**
     * Method for updating the update logic for the user account.
     *
     * @param  User  $user       The resource entity from the user that needs to be updated.
     * @param  array $attributes The array of attributes that needs to be stored in the storage.
     * @return bool
     */
    public function execute(User $user, array $attributes): bool
    {
        return DB::transaction(function() use ($user, $attributes): bool {
            if ($this->roleNeedsUpdate($attributes)) {
                $user->syncRoles($attributes['role']);
            }

            return (new UserService)->updateUser($user, $attributes);
        });
    }

    /**
     * Determine is the role needs an update or not.
     *
     * @param  array $attributes The new attributes that will stored in the database.
     * @return bool
     */
    private function roleNeedsUpdate(array $attributes): bool
    {
        return array_key_exists('role', $attributes) && $attributes['role'] !== null;
    }
}
