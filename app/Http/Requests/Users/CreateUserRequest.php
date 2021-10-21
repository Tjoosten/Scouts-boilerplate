<?php

namespace App\Http\Requests\Users;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use JetBrains\PhpStorm\ArrayShape;

class CreateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('create', User::class);
    }

    #[ArrayShape(['name' => "string[]", 'email' => "string[]", 'role' => "string[]", 'password' => "string[]"])]
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:users', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
