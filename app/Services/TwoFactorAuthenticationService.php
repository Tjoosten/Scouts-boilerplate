<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

/**
 * Class TwoFactorAuthenticationService
 *
 * @todo Refactor the enable checks to user model classes.
 * @package App\Services
 */
final class TwoFactorAuthenticationService
{
    private function userProperty(): Authenticatable|User
    {
        return Auth::user();
    }

    public function isEnabled(): bool
    {
        return ! $this->isDisabled();
    }

    public function isDisabled(): bool
    {
        return empty($this->userProperty()->two_factor_secret);
    }
}
