<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Class UserService
 *
 * @package App\Services
 */
class UserService extends BaseService
{
    /**
     * UserService constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->eloquentModel = new User();
    }

    /**
     * Method for updating the user information in the database storage.
     *
     * @param  User  $user          The resource entity from the user that needs to be updated.
     * @param  array $attributes    The array of attributes that needs to be stored in the application.
     * @return bool
     */
    public function updateUser(User $user,array $attributes): bool
    {
        if ($this->activityNeedsLogging($user)) {
            auth()->user()->logActivity('Gebruikers', __('Heeft de gegevens van :user aangepast.', ['user' => $user->name]));
        }

        return $user->update($attributes);
    }

    /**
     * Method for determining if the action needs to be logged;
     *
     * @param  User $user The entity from the user that needs the update or is created.
     * @return bool
     */
    private function activityNeedsLogging(User $user): bool
    {
        return auth()->user()->isNot(model: $user);
    }

    /**
     * Method for getting all the users in the application.
     *
     * @param  string|null $filter THe filter criteria that will be applied to the users.
     * @return Paginator
     */
    public function getUsers(?string $filter = null): Paginator
    {
        return $this->eloquentModel->when($filter === 'deactivated', static function (Builder $builder): void {
            $builder->onlyBanned();
        })->when($filter === 'activated', static function (Builder $builder): void {
            $builder->withoutBanned();
        })->paginate();
    }

    public function createUser(Request $request, array $userInformation): User
    {
        $createdUser = $this->eloquentModel->create($userInformation);

        if ($request->user()->is(model: auth()->user())) {
            $request->user()->logActivity('Gebruikers', __('Heeft :user als :role toegevoegd in :application', [
                'user' => $createdUser->name, 'role' => $request->role, 'application' => config('app.name')
            ]));
        }

        return $createdUser;
    }

    public function searchUsers(string|null $term): Paginator
    {
        if ($term === null) {
            return $this->getUsers();
        };

        return $this->eloquentModel
            ->where('name', 'LIKE', "%{$term}%")
            ->orWhere('email', 'LIKE', "%{$term}%")
            ->paginate();
    }
}
