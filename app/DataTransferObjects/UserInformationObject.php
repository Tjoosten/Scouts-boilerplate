<?php

namespace App\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class UserInformationObject extends DataTransferObject
{
    public string|null $name;
    public string|null $email;
    public string|null $password;
    public string|null $role;

    public static function fromRequest(Request $request): static
    {
        return new static([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'role' => $request->get('role'),
        ]);
    }
}
