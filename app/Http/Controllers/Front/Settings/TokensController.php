<?php

namespace App\Http\Controllers\Front\Settings;

use App\Http\Controllers\Controller;
use App\Services\TokenService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

/**
 * API tokens controller
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
            'hasTokens' => $request->user()->tokens->count() > 0
        ]);
    }
}
