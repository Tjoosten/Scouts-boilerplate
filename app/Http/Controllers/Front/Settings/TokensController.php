<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front\Settings;

use App\Http\Controllers\Controller;
use App\Services\TokenService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\DataTransferObjects\AccessTokenDataObject;
use App\Http\Requests\Users\CreateAccessTokenRequest;
use Illuminate\Http\RedirectResponse;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * API tokens controller
 *
 * This controller handles the API tokens settings in the account settings.
 * You can simply extend this controller or modify it to your needs.
 *
 * @package App\Http\Controllers\Front\Settings
 */
class TokensController extends Controller
{
    /**
     * TokensController constructor.
     *
     * @param  TokenService $tokenService The database service layer for the API (Personal access tokens)
     * @return void
     */
    public function __construct(private TokenService $tokenService) {}

    public function index(Request $request): Renderable
    {
        return view('auth.settings.apiTokens', [
            'user' => $request->user(),
            'hasTokens' => $request->user()->tokens->count() > 0,
            'tokenAbilities' => $this->tokenService->basicAbilities(),
            'tokens' => $request->user()->tokens()->paginate(7)
        ]);
    }

    /**
     * Method for creating personal access tokens in the application.
     *
     * @param  CreateAccessTokenRequest $request The validator class for the service name of the token.
     * @return RedirectResponse
     */
    public function store(CreateAccessTokenRequest $request): RedirectResponse
    {
        $accessToken = $request->user()->createToken(AccessTokenDataObject::fromRequest($request)->name);
        session()->flash('token', explode('|', $accessToken->plainTextToken, 2)[1]);

        return redirect()->action([self::class, 'index']);
    }

    /**
     * Method for revoking an access token in the application.
     *
     * @param  PersonalAccessToken $personalAccessToken The database model for the personal access tokens.
     * @return RedirectResponse
     */
    public function delete(PersonalAccessToken $personalAccessToken): RedirectResponse
    {
        $personalAccessToken->delete();

        session()->flash('message', __('De API tokens voor de service :service is met success verwijderd?', [
            'service' => $personalAccessToken->name
        ]));

        return redirect()->action([self::class, 'index']);
    }
}
