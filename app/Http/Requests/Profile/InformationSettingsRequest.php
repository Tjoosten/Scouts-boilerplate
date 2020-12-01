<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;


/**
 * Class InformationSettingsRequest
 *
 * @package App\Http\Requests\Profile
 */
class InformationSettingsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:users,email,' . $this->user()->id, 'max:255'],
        ];
    }
}
