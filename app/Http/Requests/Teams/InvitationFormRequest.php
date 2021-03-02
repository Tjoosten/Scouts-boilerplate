<?php declare(strict_types=1);

namespace App\Http\Requests\Teams;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class InvitationFormRequest extends FormRequest
{
    public function rules(): array
    {
        return ['email' => ['required', 'email', 'exists:users']];
    }
}
