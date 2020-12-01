<?php

namespace App\Actions\Users;

use App\Models\User;
use App\Notifications\Users\AccountDeletedNotification;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;

/**
 * Class DeleteUserAction
 *
 * @package App\Actions\Users
 */
class DeleteUserAction
{
    /**
     * Method for handling the delete request from the user in the application.
     *
     * @param  User $user The resource entity from the given user.
     * @return bool
     */
    public function execute(User $user): bool
    {
        return DB::transaction(function () use ($user): bool {
            $this->activityNeedsLogging($user);
            $this->sendOutEmailNotification($user);

            return (new UserService)->deleteByIdentifier($user->id);
        });
    }

    /**
     * Method for determining and logging that the user is deleted. By an admin of webmaster.
     *
     * @param  User $user The resource entity from the given user.
     * @return void
     */
    private function activityNeedsLogging(User $user): void
    {
        if (auth()->user()->isNot(model: $user)) {
            auth()->user()->logActivity('Gebruikers', 'Heeft de login van :name verwijderd.', ['user' => $user->name]);
        }
    }

    /**
     * Method dor sending out the confirmation mail that the user has been deleted in the application.
     *
     * @param  User $user The resource entity from the given user.
     * @return void
     */
    private function sendOutEmailNotification(User $user): void
    {
        if (auth()->user()->is($user)) {
            $user->notify(new AccountDeletedNotification());
        }
    }
}
