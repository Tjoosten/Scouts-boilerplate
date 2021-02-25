<?php

namespace App\Http\Controllers\Front\Settings;

use App\DataTransferObjects\UserInformationObject;
use App\Http\Controllers\Controller;
use App\Http\Requests\OtherSessionsRequest;
use App\Http\Requests\Profile\SecuritySettingsRequest;
use App\Services\UserService;
use App\Services\UserSessionService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
    public function index(Request $request, UserSessionService $userSessionService): Renderable
    {
        return view('auth.settings.security', [
            'user' => $request->user(),
            'authSessions' => $userSessionService->getProperties(),
            'canLogoutAuthSessions' => $userSessionService->canLogoutOtherSession(),
        ]);
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
