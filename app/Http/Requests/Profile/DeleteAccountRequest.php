<?php

namespace App\Http\Requests\Profile;

use App\Rules\MatchUserPassword;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class DeleteAccountRequest extends FormRequest
{
    #[Pure]
    #[ArrayShape(['password' => "array"])]
    public function rules(): array
    {
        return ['password' => ['required', 'string', new MatchUserPassword()]];
    }
}
