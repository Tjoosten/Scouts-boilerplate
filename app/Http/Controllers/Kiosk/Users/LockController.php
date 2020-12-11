<?php

namespace App\Http\Controllers\Kiosk\Users;

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
    /**
     * LockController constructor.
     *
     * @param  UserService $userService The abstraction layer for all the logic that is related to the users.
     * @return void
     */
    public function __construct(
        private UserService $userService
    ) {}

    /**
     * Method for displaying the deactivation view for the given user.
     *
     * @param  User $user The resource entity from the given user.
     * @return Renderable
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(User $user): Renderable
    {
        $this->authorize('deactivate', $user);

        return view('kiosk.users.deactivate', compact('user'));
    }

    /**
     * Method for deactivating the user in the application.
     * ---
     * See the request class for the authorization check.
     *
     * @param  DeactivateFormRequest $request           The request instance that contains all the request information.
     * @param  User                  $userEntity        The resource entity from the given user.
     * @param  DeactivateAction      $deactivateAction  The action that handles the deactivation of the user in the storage.
     * @return RedirectResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(DeactivateFormRequest $request, User $userEntity, DeactivateAction $deactivateAction): RedirectResponse
    {
        $deactivateAction->execute($userEntity, UserDeactivationObject::fromRequest($request));

        return redirect()->route('kiosk.users.show', $userEntity);
    }

    public function destroy(User $userEntity): RedirectResponse
    {

    }
}
