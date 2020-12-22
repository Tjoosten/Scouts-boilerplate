<?php

namespace App\Http\Requests;

use App\Rules\MatchUserPassword;
use Illuminate\Foundation\Http\FormRequest;

class OtherSessionsRequest extends FormRequest
{
    public function rules(): array
    {
        return ['password-confirmation' => ['string', 'required', new MatchUserPassword()]];
    }
}
