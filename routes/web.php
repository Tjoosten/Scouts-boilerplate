<?php

use App\Http\Controllers\Front\DashboardController;
use App\Http\Controllers\Front\AccountController;
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
    Route::delete('/Account-verwijderen', [AccountController::class, 'destroy'])->name('account.delete');

    Route::group(['prefix' => 'account-instellngen'], static function (): void {
        Route::get('/', [AccountController::class, 'index'])->name('account.settings');
        Route::patch('/informatie', [AccountController::class, 'updateInformation'])->name('account.settings.information');
        Route::patch('/security', [AccountController::class, 'updateSecurity'])->name('account.settings.security');
    });

   Route::get('/home', DashboardController::class)->name('home');
});

