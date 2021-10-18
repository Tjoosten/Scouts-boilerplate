<?php

declare(strict_types=1);

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

final class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('update', $this->userEntity);
    }

    public function rules(): array
    {
        return [];
    }
}
