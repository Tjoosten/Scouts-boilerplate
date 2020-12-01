<?php

namespace App\Actions\Users;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;

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
        return DB::transaction(static function() use ($user, $attributes): bool {
            return (new UserService)->updateUser($user, $attributes);
        });
    }
}
