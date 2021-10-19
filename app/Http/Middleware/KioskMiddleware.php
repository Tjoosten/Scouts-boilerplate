<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class KioskMiddleware
{
    public function __construct(
        private Guard $auth
    ) {}

    public function handle(Request $request, Closure $next): mixed
    {
        if (! $this->auth->user()->hasKioskRoles()) {
            flash(__('U hebt niet genoeg permissies voor de applicatie kiosk.'), 'alert-danger');
            return redirect()->route('welcome');
        }

        return $next($request);
    }
}
