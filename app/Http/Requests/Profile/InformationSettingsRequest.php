<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class InformationSettingsRequest extends FormRequest
{
    #[ArrayShape(['name' => "string[]", 'email' => "string[]"])]
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:users,email,' . $this->user()->id, 'max:255'],
        ];
    }
}
