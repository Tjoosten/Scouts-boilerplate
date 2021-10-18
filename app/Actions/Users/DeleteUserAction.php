<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\User;
use App\Notifications\Users\AccountDeletedNotification;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

final class DeleteUserAction
{
    public function execute(User $user): bool
    {
        return DB::transaction(function () use ($user): bool {
            $this->activityNeedsLogging($user);
            $this->sendOutEmailNotification($user);

            return (new UserService)->deleteByIdentifier($user->id);
        });
    }

    private function activityNeedsLogging(User $user): void
    {
        $authenticatedUser = auth()->user();

        if ($authenticatedUser?->isNot(model: $user)) {
            $authenticatedUser?->logActivity('Gebruikers', 'Heeft de login van :name verwijderd.', ['user' => $user->name]);
        }
    }

    private function sendOutEmailNotification(User $user): void
    {
        if (auth()->user()?->is($user)) {
            Notification::route('mail', $user->email)->notify(new AccountDeletedNotification());
        }
    }
}
