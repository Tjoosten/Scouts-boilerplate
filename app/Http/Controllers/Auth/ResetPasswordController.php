<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

/**
 * Password reset controller
 *
 * This controller is responsible for handling the password reset requests
 * and uses a simple trait to include this behaviour. You're free to
 * explore this trait and override any methods you wish to tweak.
 */
class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
}
