<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\MatchUserPassword;
use Illuminate\Foundation\Http\FormRequest;

final class OtherSessionsRequest extends FormRequest
{
    public function rules(): array
    {
        return ['password-confirmation' => ['string', 'required', new MatchUserPassword()]];
    }
}
