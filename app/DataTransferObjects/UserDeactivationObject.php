<?php

namespace App\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class UserDeactivationObject extends DataTransferObject
{
    public string $comment;

    public static function fromRequest(Request $request): static
    {
        return new static(['comment' => $request->get('reden')]);
    }
}
