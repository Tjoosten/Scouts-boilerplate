<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
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
    public function __invoke(Request $request): Renderable
    {
        return view('auth.settings', ['user' => $request->user()]);
    }
}
