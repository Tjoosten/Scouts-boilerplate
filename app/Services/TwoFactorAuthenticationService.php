<?php

namespace App\Services;

use App\Models\TwoFactorAuthentication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;

/**
 * Class TwoFactorAuthenticationService
 *
 * @package App\Services
 */
class TwoFactorAuthenticationService
{
    public function __construct()
    {
        $this->model = new TwoFactorAuthentication;
    }

    /**
     * Metho)d for creating the secret key during the configuration.
     */
    public function createSecretKey(Request $request): TwoFactorAuthentication
    {
        return DB::transaction(function () use ($request): TwoFactorAuthentication {
           return $this->model->create([
               'user_id' => $request->user()->id,
               'google2fa_secret' => $this->google2faLayer()->generateSecretKey(),
               'google2fa_recovery_tokens' => $this->generateRecoveryTokens(),
               'google2fa_enable' => false,
           ]);
        });
    }

    public function regenerateTokens(User $user)
    {
    }

    private function google2faLayer(): Google2FA
    {
        return app('pragmarx.google2fa');
    }

    private function generateRecoveryTokens(): string
    {
        return encrypt(json_encode(Collection::times(8, fn(): string =>
            Str::random(10) . '-' . Str::random(10)
        )));
    }
}
