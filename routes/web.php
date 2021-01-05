<?php

use App\Http\Controllers\Front\DashboardController;
use App\Http\Controllers\Front\AccountController;
use App\Http\Controllers\Front\Settings\DeleteController;
use App\Http\Controllers\Front\Settings\InformationController;
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

Auth::routes();
Route::get('/', WelcomeController::class)->name('welcome');

Route::group(['middleware' => ['auth', 'forbid-banned-user']], static function () {
    Route::delete('/Account-verwijderen', DeleteController::class)->name('account.delete');

    Route::group(['prefix' => 'account-instellngen'], static function (): void {
        Route::get('/informatie', [InformationController::class, 'index'])->name('account.settings.information');
        Route::patch('/informatie', [InformationController::class, 'update'])->name('account.settings.information');
        Route::get('/security', [SecurityController::class, 'index'])->name('account.settings.security');
        Route::patch('/security', [SecurityController::class, 'update'])->name('account.settings.security');
        Route::post('/remove-sessions', [SecurityController::class, 'destroy'])->name('account.delete-sessions');
    });

    // Personal access tokens routes
    if (config('boilerplate.features.api')) {
        Route::group(['prefix' => 'api'], static function (): void {
            Route::get('tokens', [TokensController::class, 'index'])->name('api.tokens');
        });
    }

   Route::get('/home', DashboardController::class)->name('home');
});

