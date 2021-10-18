<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\MatchUserPassword;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

final class OtherSessionsRequest extends FormRequest
{
    #[Pure]
    #[ArrayShape(['password-confirmation' => "array"])]
    public function rules(): array
    {
        return ['password-confirmation' => ['string', 'required', new MatchUserPassword()]];
    }
}
