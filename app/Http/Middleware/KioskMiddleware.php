<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

/**
 * Class KioskMiddleware
 *
 * @package App\Http\Middleware
 */
class KioskMiddleware
{
    /**
     * KioskMiddleware constructor.
     *
     * @param  Guard $auth The guard layer for the authenticated user.
     * @return void
     */
    public function __construct(
        private Guard $auth
    ) {}

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (! $this->auth->user()->hasKioskRoles()) {
            flash(__('U hebt niet genoeg permissies voor de applicatie kiosk.'), 'alert-danger');
            return redirect()->route('welcome');
        }

        return $next($request);
    }
}
