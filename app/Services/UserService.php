<?php

namespace App\Services;

use App\Models\User;

/**
 * Class UserService
 *
 * @package App\Services
 */
class UserService extends BaseService
{
    /**
     * UserService constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->eloquentModel = new User();
    }

    /**
     * Method for updating the user information in the database storage.
     *
     * @param  User  $user          The resource entity from the user that needs to be updated.
     * @param  array $attributes    The array of attributes that needs to be stored in the application.
     * @return bool
     */
    public function updateUser(User $user,array $attributes): bool
    {
        if ($this->activityNeedsLogging($user)) {
            auth()->user()->logActivity('Gebruikers', __('Heeft de gegevens van :user aangepast.', ['user' => $user->name]));
        }

        return $user->update($attributes);
    }

    /**
     * Method for determining if the action needs to be logged;
     *
     * @param  User $user The entity from the user that needs the update or is created.
     * @return bool
     */
    private function activityNeedsLogging(User $user): bool
    {
        return auth()->user()->isNot(model: $user);
    }
}
