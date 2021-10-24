<?php

namespace App\Http\Controllers\Front\Settings;

use App\Actions\Users\UpdateUserAction;
use App\DataTransferObjects\UserInformationObject;
use App\Http\Controllers\Controller;
use App\Http\Requests\OtherSessionsRequest;
use App\Http\Requests\Profile\SecuritySettingsRequest;
use App\Services\UserSessionService;
use App\Services\TwoFactorAuthenticationService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Fortify\Features;

/**
 * Class SecurityController
 *
 * @package App\Http\Controllers\Front\Settings
 */
class SecurityController extends Controller
{
    /**
     * Method for displaying the security settings for the user account.
     */
    public function index(
        Request $request,
        UserSessionService $userSessionService,
        TwoFactorAuthenticationService $twoFactorAuthenticationService
    ): Renderable {
        return view('auth.settings.security', [
            'user' => $request->user(),
            'authSessions' => $userSessionService->getProperties(),
            'canLogoutAuthSessions' => $userSessionService->canLogoutOtherSession(),
            'twoFactorFeatureEnabled' => Features::enabled(Features::twoFactorAuthentication()),
            'twoFactorAuthenticationDisabled' => $twoFactorAuthenticationService->isDisabled(),
            'twoFactorAuthenticationEnabled' => $twoFactorAuthenticationService->isEnabled(),
        ]);
    }

    /**
     * Method for updating the user password information in the application.
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
     */
    public function destroy(OtherSessionsRequest $request, UserSessionService $userSessionService): RedirectResponse
    {
        $userSessionService->logoutOtherBrowserSessions($request->get('password-confirmation'));

        return redirect()->route('account.settings.security');
    }
}
