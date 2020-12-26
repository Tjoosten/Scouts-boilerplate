<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\TwoFactorAuthenticationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;

class TwoFactorAuthController extends Controller
{
    public function __construct(
        private TwoFactorAuthenticationService $twoFactorAuthenticationService
    ) {}

    /**
     * Method for generating the challenge for the 2FA authenticator code.
     */
    public function challenge(Request $request): RedirectResponse
    {
        $route = redirect()->route('account.settings.security');

        try {
            $this->twoFactorAuthenticationService->createSecretKey($request);
            return $route->with('success', __('Two Factor authenticatie is geactiveerd. Scan de volgende QR code met je Google authenticator app.'));
        } catch (IncompatibleWithGoogleAuthenticatorException $incompatibleWithGoogleAuthenticatorException) {
            return $route->with('error', __($incompatibleWithGoogleAuthenticatorException->getMessage()));
        } catch (InvalidCharactersException $invalidCharactersException) {
            return $route->with('error', __($invalidCharactersException->getMessage()));
        }
    }

    /**
     * Method for enabling the Two factor authentication on the user account.
     */
    public function enable(Request $request, EnableTwoFactorAuth $enableTwoFactorAuthAction): RedirectResponse
    {
        $redirect = redirect()->route('account.settings.security');

        if ($enableTwoFactorAuthAction->execute($request->user(), $request->get('verify-code'))) {
            flash()->success(__('Two factor authenticatie is met success geactiveer op uw account.'), 'alert-success');
            session()->flash('recoveryTokens', $request->user()->get2faRecoveryTokens());

            return $redirect;
        }

        return $redirect->with('error', __('Invalide Google authenticator code. Probeer het opnieuw'));
    }

    /**
     * Method for regenerating the 2FA recovery tokens.
     */
    public function regenerate(Request $request): RedirectResponse
    {
        if ($request->user()->isUsingTwoFacotrAuthentication()) {
            $this->twoFactorAuthenticationService->regenerateTokens($request->user());
            session()->flash('recoveryTokens', $request->user()->get2faRecoveryTokens());
        }

        return redirect()->route('account.settings.security');
    }
}
