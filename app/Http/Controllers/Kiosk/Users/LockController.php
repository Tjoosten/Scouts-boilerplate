<?php

namespace App\Http\Controllers\Kiosk\Users;

use App\Actions\Users\ActivateAction;
use App\Actions\Users\DeactivateAction;
use App\DataTransferObjects\UserDeactivationObject;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\DeactivateFormRequest;
use App\Models\User;
use App\Services\UserService;
use Cog\Laravel\Ban\Models\Ban;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

/**
 * Class LockController
 *
 * @package App\Http\Controllers\Kiosk\Users
 */
class LockController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}

    /**
     * @see    \App\Policies\UserPolicy::deactivate()
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(User $user): Renderable
    {
        $this->authorize('deactivate', $user);

        return view('kiosk.users.deactivate', compact('user'));
    }

    /* @see \App\Policies\UserPolicy::deactivate()
     * @see \App\Http\Requests\Users\DeactivateFormRequest::authorize()
     */
    public function store(DeactivateFormRequest $request, User $userEntity, DeactivateAction $deactivateAction): RedirectResponse
    {
        $deactivateAction->execute($userEntity, UserDeactivationObject::fromRequest($request));

        return redirect()->route('kiosk.users.show', $userEntity);
    }

    /**
     * @see    \App\Policies\UserPolicy::activate()
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(User $userEntity, ActivateAction $activateAction): RedirectResponse
    {
        $this->authorize('activate', $userEntity);

        $activateAction->execute($userEntity);
        flash(__('De gebruikers account van :name is terug geactiveerd.', ['name' => $userEntity->name]), 'alert-success');

        return redirect()->route('kiosk.users.show', $userEntity);
    }
}
