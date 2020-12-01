<?php

namespace App\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * Class UserInformationObject
 *
 * @package App\DataTransferObjects
 */
class UserInformationObject extends DataTransferObject
{
    public string|null $name;
    public string|null $email;
    public string|null $password;

    /**
     * Method for mapping the form request data to an object.
     *
     * @param  Request $request The request entity that contains all the request information.
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ]);
    }
}
