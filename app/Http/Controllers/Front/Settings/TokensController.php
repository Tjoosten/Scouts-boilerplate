<?php

namespace App\Http\Controllers\Front\Settings;

use App\DataTransferObjects\AccessTokenDataObject;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\CreateAccessTokenRequest;
use App\Services\TokenService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * API tokens controller
 *
 * @todo Write tests
 *
 * This controller handles the API tokens settings in the account settings.
 * You can simply extend this controller or modify it to your needs.
 */
class TokensController extends Controller
{
    public function __construct(private TokenService $tokenService) {}

    public function index(Request $request): Renderable
    {
        return view('auth.settings.apiTokens', [
            'user' => $request->user(),
            'hasTokens' => $request->user()->tokens->count() > 0,
            'tokens' => $request->user()->tokens()->paginate(7)
        ]);
    }

    /**
     * Method for creating personal access tokens in the application.
     */
    public function store(CreateAccessTokenRequest $request): RedirectResponse
    {
        $accessToken = $request->user()->createToken(AccessTokenDataObject::fromRequest($request)->name);
        session()->flash('token', explode('|', $accessToken->plainTextToken, 2)[1]);

        return redirect()->action([self::class, 'index']);
    }

    /**
     * Method for revoking an access token in the application.
     */
    public function delete(PersonalAccessToken $personalAccessToken): RedirectResponse
    {
        $personalAccessToken->delete();
        session()->flash('message', __('De API tokens voor de service :service is met success verwijderd?', ['service' => $personalAccessToken->name]));

        return redirect()->action([self::class, 'index']);
    }
}
