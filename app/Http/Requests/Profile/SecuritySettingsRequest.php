<?php

namespace App\Http\Requests\Profile;

use App\Rules\MatchUserPassword;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class SecuritySettingsRequest extends FormRequest
{
    #[Pure]
    #[ArrayShape(['currentPassword' => "array", 'password' => "string[]"])]
    public function rules(): array
    {
        return [
            'currentPassword' => ['required', 'string', new MatchUserPassword()],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
