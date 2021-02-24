<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::loginView(fn(): Renderable => view('auth.login'));
        Fortify::registerView(fn(): Renderable => view('auth.register'));
        Fortify::requestPasswordResetLinkView(fn (): Renderable => view('auth.passwords.email'));
        Fortify::resetPasswordView(fn (Request $request): Renderable => view('auth.passwords.reset', ['request' => $request]));
        Fortify::verifyEmailView(fn (): Renderable => view('auth.verify'));
        Fortify::confirmPasswordView(fn (): Renderable => view('auth.passwords.confirm'));
        Fortify::twoFactorChallengeView(fn (): Renderable => view('auth.two-factor.challenge'));

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->email.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
