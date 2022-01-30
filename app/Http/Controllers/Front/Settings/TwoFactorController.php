<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;

/**
 * Class TwoFactorController
 *
 * This controllers adds the functionality that the user allows to setup up two factor authentication
 * as additional security layer for their user account. Note that this controller is an exception on the no documentation
 * policy. Because we cant our authentication as clear as possible. Also worth mentioning that you are free to modify
 * this controller to your needs.
 *
 * @todo The 2FA authentication flow needs testing with the Google Authenticator app.
 *
 * @todo IDEA: Implement method in the backend where the webmaster can reset the two factor authentication.
 * @todo IDEA: Implement command artisan where the develop can reset the two factor authentication.
 * @todo IDEA: JSON responses for when the user wants to use the two factor authentication settings in his API.
 *
 * @package App\Http\Controllers\Front\Settings
 */
final class TwoFactorController extends Controller
{
    /**
     * TwoFactorController constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('password.confirm')->except('enable');
    }

    /**
     * Method for enabling the Two Factor authentication for the application user account.
     *
     * @todo Build up the current password validator request.
     *
     * @param  Request                       $request                       Request instance that handles the input validation.
     * @param  EnableTwoFactorAuthentication $enableTwoFactorAuthentication Laravel Fortify action that enables the 2FA
     * @return RedirectResponse
     */
    public function enable(Request $request, EnableTwoFactorAuthentication $enableTwoFactorAuthentication): RedirectResponse
    {
        $enableTwoFactorAuthentication($request->user());

        return redirect()->action([SecurityController::class, 'index'])
            ->with('showingQrCode', true)
            ->with('showingRecoveryCodes', true);
    }

    /**
     * Method for disabling the two factor authentication settings in his account on the application.
     * 
     * @return RedirectResponse
     */
    public function disable(): RedirectResponse
    {
        dd('TODO: needs implementation');
    }

    /**
     * Method for generating new recovery codes for the user his two factor authentication settings.
     *
     * @return RedirectResponse
     */
    public function recoveryCodes(): RedirectResponse
    {
        dd('TODO: needs implementation');
    }
}
