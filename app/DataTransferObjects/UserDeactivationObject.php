<?php

namespace App\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * Class UserDeactivationObject
 *
 * @package App\DataTransferObjects
 */
class UserDeactivationObject extends DataTransferObject
{
    public string $comment;

    /**
     * Method for mapping the request data to an object.
     *
     * @param  Request $request The request entity that contains all the request information.
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(['comment' => $request->get('reden')]);
    }
}
