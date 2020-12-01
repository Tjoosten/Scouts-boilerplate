<?php

namespace App\Http\Requests\Profile;

use App\Rules\MatchUserPassword;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SecuritySettingsRequest
 *
 * @package App\Http\Requests\Profile
 */
class SecuritySettingsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'currentPassword' => ['required', 'string', new MatchUserPassword()],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
