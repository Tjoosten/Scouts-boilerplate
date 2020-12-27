<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\TwoFactorAuthentication;

/**
 * Two Factor authentication methods
 *
 * Methods that are related to the two factor authentication layer in the application.
 * Mainly checks kan be found here in this traits.
 *
 * @method mixed hasOne() hasOne(mixed $model) Data relation type in laravel.
 *
 * @package App\Models\Traits
 */
trait TwoFactorAuthmethods
{
	/**
	 * Data relation for the two factor authentication information.
	 *
	 * @return HasOne
	 */
	public function twoFactorAuth(): HasOne
	{
		return $this->hasOne(TwoFactorAuthentication::class);
	}

	public function twoFactorFeatureEnabled(): bool
	{
		return config('google2fa.enabled');
	}

	public function canSetupTwoFactorAuthentication(): bool
	{
		return $this->twoFactorFeatureEnabled() === true && empty($this->twoFactorAuth);
	}
}
