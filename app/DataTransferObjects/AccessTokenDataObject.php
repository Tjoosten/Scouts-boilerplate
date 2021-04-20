<?php

namespace App\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class AccessTokenDataObject extends DataTransferObject
{
    public string $name;

    public static function fromRequest(Request $request): static
    {
        return new static(['name' => $request->get('name')]);
    }
}
