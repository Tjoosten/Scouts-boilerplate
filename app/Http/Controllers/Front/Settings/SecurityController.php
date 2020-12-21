<?php

namespace App\Http\Controllers\Front\Settings;

use App\Actions\Users\UpdateUserAction;
use App\DataTransferObjects\UserInformationObject;
use App\Http\Controllers\Controller;
use App\Http\Requests\OtherSessionsRequest;
use App\Http\Requests\Profile\SecuritySettingsRequest;
use App\Services\UserService;
use App\Services\UserSessionService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SecurityController extends Controller
{
    public function index(Request $request, UserSessionService $userSessionService): Renderable
    {
        return view('auth.settings.security', [
            'user' => $request->user(),
            'authSessions' => $userSessionService->getProperties(),
            'canLogoutAuthSessions' => $userSessionService->canLogoutOtherSession(),
        ]);
    }

    /**
     * Method for updating the user password information in the application.
     *
     * @param  SecuritySettingsRequest $request
     * @param  UpdateUserAction        $updateUserAction
     * @return RedirectResponse
     */
    public function update(SecuritySettingsRequest $request, UpdateUserAction $updateUserAction): RedirectResponse
    {
        $attributes = UserInformationObject::fromRequest($request)->only('password')->toArray();
        $securityUpdate = $updateUserAction->execute($request->user(), $attributes);

        session()->flash('securityUpdated', ['success' => $securityUpdate]);

        return redirect()->route('account.settings.security');
    }

    /**
     * Method for deleting all the other browser session from the authenticated user.
     *
     * @param  OtherSessionsRequest $request
     * @param  UserSessionService   $userSessionService
     * @return RedirectResponse
     */
    public function destroy(OtherSessionsRequest $request, UserSessionService $userSessionService): RedirectResponse
    {
        $userSessionService->logoutOtherBrowserSessions($request->get('password-confirmation'));

        return redirect()->route('account.settings.security');
    }
}
