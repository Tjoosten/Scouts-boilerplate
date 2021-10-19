<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use JetBrains\PhpStorm\ArrayShape;

class DeactivateFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('deactivate', $this->userEntity);
    }

    #[ArrayShape(['reden' => "string[]"])]
    public function rules(): array
    {
        return ['reden' => ['required', 'string']];
    }
}
