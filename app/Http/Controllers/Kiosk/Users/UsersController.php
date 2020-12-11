<?php

namespace App\Http\Controllers\Kiosk\Users;

use App\Actions\Users\CreateUserAction;
use App\Actions\Users\DeleteUserAction;
use App\Actions\Users\UpdateUserAction;
use App\DataTransferObjects\UserInformationObject;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\User;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Class UsersController
 *
 * @package App\Http\Controllers\Kiosk\Users
 */
class UsersController extends Controller
{
    /**
     * UsersController constructor.
     *
     * @param  UserService $userService Database abstraction layer that is related for the users.
     * @param  RoleService $roleService Database abstraction layer that is related to the permission roles.
     * @return void
     */
    public function __construct(
        private UserService $userService,
        private RoleService $roleService
    ) {}

    /**
     * Method for displaying all the users in the application.
     *
     * @param  string|null $filter The filter to apply on the users from the database.
     * @return Renderable
     */
    public function index(string|null $filter = null): Renderable
    {
       return view('kiosk.users.index', ['users' => $this->userService->getUsers($filter)]);
    }

    /**
     * Method for displaying the user information in the application.
     *
     * @param  User $user The resource entity from the given user.
     * @return Renderable
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(User $user): Renderable
    {
        $this->authorize('show', $user);

        return view('kiosk.users.show', compact('user'));
    }

    /**
     * Method for displaying the edit view from the given user.
     *
     * @param  User $user The resource entity from the given user.
     * @return Renderable
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user): Renderable
    {
        $this->authorize('update', $user);

        return view('kiosk.users.edit', ['user' => $user, 'roles' => $this->roleService->getRoles()]);
    }

    /**
     * Method for displaying the create view for a new user.
     *
     * @return Renderable
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(): Renderable
    {
        $this->authorize('create', User::class);

        return view('kiosk.users.create', ['roles' => $this->roleService->getRoles()]);
    }

    /**
     * @see \App\Http\Requests\Users\CreateUserRequest::authorize()
     * @see \App\Policies\UserPolicy::create()
     */
    public function store(CreateUserRequest $request, CreateUserAction $createUserAction): RedirectResponse
    {
        $user = $createUserAction->execute($request, UserInformationObject::fromRequest($request));

        return redirect()->route('kiosk.users.show', $user);
    }

    /**
     * Method for updating the user in the application.
     * ---
     * See the form request class for the request authorization.
     *
     * @todo Complete the form request rules.
     *
     * @param  UpdateUserRequest $request          The request entity that contains all the request information.
     * @param  User              $userEntity       The resource entity from the authenticated user.
     * @param  UpdateUserAction  $updateUserAction The update action that handles all the needed logic.
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $userEntity, UpdateUserAction $updateUserAction): RedirectResponse
    {
        $requestData = $request->filled('password')
            ? UserInformationObject::fromRequest($request)->toArray()
            : UserInformationObject::fromRequest($request)->except('password')->toArray();

        $updateUserAction->execute($userEntity, $requestData);
        flash(__('Het gebruikers account van :user is met success aangepast.', ['user' => $userEntity->name]), 'alert-success');

        return redirect()->route('kiosk.users.show', $userEntity);
    }

    /**
     * Method for deleting an user account in the application.
     *
     * @param  User             $user             The resource entity from the given user.
     * @param  DeleteUserAction $deleteUserAction The handling for deleting the user in the application.
     * @return RedirectResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(User $user, DeleteUserAction $deleteUserAction): RedirectResponse
    {
        $this->authorize('delete', $user);
        $deleteUserAction->execute($user);

        $languageKeys = ['user' => $user->name, 'application' => config('app.name')];
        flash(__('De login van :user is verwijderd in :application', $languageKeys), 'alert-success');

        return redirect()->route('kiosk.users.index');
    }
}
