<?php

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class ActivateAction
{
    public function execute(User $user): void
    {
        DB::transaction(static function () use ($user): void {
            auth()->user()?->logActivity('Gebruikers', __('Heeft de login van :user terug geactiveerd in :applicatie', [
                'user' => $user->name, 'applicatie' => config('app.name'),
            ]));

            $user->unban();
        });
    }
}
