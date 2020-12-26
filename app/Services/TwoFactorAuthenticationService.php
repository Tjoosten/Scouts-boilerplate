<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;

class TwoFactorAuthenticationService
{
    public function createSecretKey(Request $request)
    {
    }

    public function regenerateTokens(User $user)
    {
    }
}
