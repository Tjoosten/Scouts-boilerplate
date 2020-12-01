<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

/**
 * Class MatchUserPassword
 *
 * @package App\Rules
 */
class MatchUserPassword implements Rule
{
    /**
     * {@inheritDoc}
     */
    public function passes($attribute, $value)
    {
        return Hash::check($value, auth()->user()->getAuthPassword());
    }

    /**
     * {@inheritDoc}
     */
    public function message()
    {
        return __('Het opgegeven wachtwoord komt niet overeen met je huidige wachtwoord.');
    }
}
