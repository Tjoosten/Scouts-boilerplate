<?php

namespace App\Actions\Users;

use App\DataTransferObjects\UserInformationObject;
use App\Models\User;
use App\Notifications\Users\UserCreatedNotification;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreateUserAction
{
    public function execute(Request $request, UserInformationObject $informationObject): User
    {
        $userInformation = $informationObject->except('role')->toArray();

        return DB::transaction(static function () use ($request, $userInformation, $informationObject): User {
            $createdUser = (new UserService)->createUser($request, $userInformation);
            $createdUser->assignRole($informationObject->role);
            $createdUser->notify(new UserCreatedNotification($informationObject->password));

            return $createdUser;
        });
    }
}
