<?php

namespace App\Http\Requests\Profile;

use App\Rules\MatchUserPassword;
use Illuminate\Foundation\Http\FormRequest;

class DeleteAccountRequest extends FormRequest
{
    public function rules(): array
    {
        return ['password' => ['required', 'string', new MatchUserPassword()]];
    }
}
