<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\Pure;

final class UpdateUserAction
{
    public function execute(User $user, array $attributes): bool
    {
        return DB::transaction(function() use ($user, $attributes): bool {
            if ($this->roleNeedsUpdate($attributes)) {
                $user->syncRoles($attributes['role']);
            }

            return (new UserService)->updateUser($user, $attributes);
        });
    }

    private function roleNeedsUpdate(array $attributes): bool
    {
        return array_key_exists('role', $attributes) && $attributes['role'] !== null;
    }
}
