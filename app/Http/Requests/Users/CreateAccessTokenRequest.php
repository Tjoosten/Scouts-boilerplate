<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class CreateAccessTokenRequest extends FormRequest
{
    #[ArrayShape(['name' => "string[]"])]
    public function rules(): array
    {
        return ['name' => ['required', 'string', 'max:255']];
    }
}
