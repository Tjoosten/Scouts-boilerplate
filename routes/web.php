<?php

use App\Http\Controllers\Front\DashboardController;
use App\Http\Controllers\Front\Settings\DeleteController;
use App\Http\Controllers\Front\Settings\SecurityController;
use App\Http\Controllers\Front\Settings\TokensController;
use App\Http\Controllers\Front\WelcomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', WelcomeController::class)->name('welcome');

Route::group(['middleware' => ['auth', 'forbid-banned-user']], static function () {
    Route::match(['GET', 'DELETE'], '/Account-verwijderen', DeleteController::class)->name('account.delete');

    Route::group(['prefix' => 'account-instellngen'], static function (): void {
        Route::view('/informatie', 'auth.settings.information')->name('account.settings.information');
        Route::get('/beveiliging', [SecurityController::class, 'index'])->name('account.settings.security');
        Route::post('/remove-sessions', [SecurityController::class, 'destroy'])->name('account.delete-sessions');
    });

    // Personal access tokens routes
    if (config('boilerplate.features.api')) {
        Route::group(['prefix' => 'api'], static function (): void {
            Route::get('/tokens', [TokensController::class, 'index'])->name('api.tokens');
            Route::post('/tokens', [TokensController::class, 'store'])->name('api.tokens.store');
            Route::get('/token/revoke/{personalAccessToken}', [TokensController::class, 'delete'])->name('api.tokens.revoke');
        });
    }

   Route::get('/home', DashboardController::class)->name('home');
});

