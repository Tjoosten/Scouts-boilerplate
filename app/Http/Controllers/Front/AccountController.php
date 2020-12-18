<?php

namespace App\Http\Controllers\Front;

use App\Actions\Users\DeleteUserAction;
use App\Actions\Users\UpdateUserAction;
use App\DataTransferObjects\UserInformationObject;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\InformationSettingsRequest;
use App\Http\Requests\Profile\SecuritySettingsRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Class AccountController
 *
 * @package App\Http\Controllers\Front\Settings
 */
class AccountController extends Controller
{
    /**
     * Method for displaying the settings page from the authenticated user.
     *
     * @param  Request $request The request class that contains the request information.
     * @return Renderable
     */
    public function index(Request $request): Renderable
    {
        return view('auth.settings', ['user' => $request->user()]);
    }

    /**
     * Method for updating the account information from the authenticated user.
     *
     * @param  InformationSettingsRequest $request          The request instance that contains all the request information.
     * @param  UpdateUserAction           $updateUserAction The action that handles the update action for the user.
     * @return RedirectResponse
     */
    public function updateInformation(InformationSettingsRequest $request, UpdateUserAction $updateUserAction): RedirectResponse
    {
        $attributes = UserInformationObject::fromRequest($request)->except('password')->toArray();
        $informationUpdate = $updateUserAction->execute($request->user(), $attributes);

        session()->flash('informationUpdated', $informationUpdate);

        return redirect()->route('account.settings');
    }


    /**
     * Method for updating the account security from the authenticated user.
     *
     * @param  SecuritySettingsRequest $request          The request instance that contains all the request information.
     * @param  UpdateUserAction        $updateUserAction The action that handles the update action for the user.
     * @return RedirectResponse
     */
    public function updateSecurity(SecuritySettingsRequest $request, UpdateUserAction $updateUserAction): RedirectResponse
    {
        $attributes = UserInformationObject::fromRequest($request)->only('password')->toArray();
        $securityUpdate = $updateUserAction->execute($request->user(), $attributes);

        session()->flash('securityUpdated', ['success' => $securityUpdate]);

        return redirect()->route('account.settings');
    }

    /**
     * Method for deleting a user account in the application.
     *
     * @param  Request          $request          The request entity that contains all the request information.
     * @param  DeleteUserAction $deleteUserAction The action that handles the account deletion in the application.
     * @return RedirectResponse
     */
    public function destroy(Request $request, DeleteUserAction $deleteUserAction): RedirectResponse
    {
        $deleteUserAction->execute($request->user());

        return redirect()->route('login');
    }
}
