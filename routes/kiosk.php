<?php

use App\Http\Controllers\Kiosk\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Kiosk Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['auth', 'kiosk']], static function (): void {
    Route::get('/', DashboardController::class)->name('kiosk.dashboard');
});
