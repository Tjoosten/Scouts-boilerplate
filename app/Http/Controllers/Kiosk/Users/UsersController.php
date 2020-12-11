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

/**
 * Class UsersController
 *
 * @package App\Http\Controllers\Kiosk\Users
 */
class UsersController extends Controller
{
    public function __construct(
        private UserService $userService,
        private RoleService $roleService
    ) {}

    public function index(string|null $filter = null): Renderable
    {
       return view('kiosk.users.index', ['users' => $this->userService->getUsers($filter)]);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(User $user): Renderable
    {
        $this->authorize('show', $user);

        return view('kiosk.users.show', compact('user'));
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user): Renderable
    {
        $this->authorize('update', $user);

        return view('kiosk.users.edit', ['user' => $user, 'roles' => $this->roleService->getRoles()]);
    }

    /**
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

    public function update(UpdateUserRequest $request, User $userEntity, UpdateUserAction $updateUserAction): RedirectResponse
    {
        $requestData = $request->filled('password')
            ? UserInformationObject::fromRequest($request)->toArray()
            : UserInformationObject::fromRequest($request)->except('password')->toArray();

        $updateUserAction->execute($userEntity, $requestData);
        flash(__('Het gebruikers account van :user is met success aangepast.', ['user' => $userEntity->name]), 'alert-success');

        return redirect()->route('kiosk.users.show', $userEntity);
    }

    public function destroy(User $user, DeleteUserAction $deleteUserAction): RedirectResponse
    {
        $this->authorize('delete', $user);
        $deleteUserAction->execute($user);

        $languageKeys = ['user' => $user->name, 'application' => config('app.name')];
        flash(__('De login van :user is verwijderd in :application', $languageKeys), 'alert-success');

        return redirect()->route('kiosk.users.index');
    }
}
