<?php

namespace App\Http\Controllers\Kiosk;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;

/**
 * Class DashboardController
 *
 * @package App\Http\Controllers\Kiosk
 */
class DashboardController extends Controller
{
    /**
     * Method for displaying the kiosk dashboard in the application;
     *
     * @return Renderable
     */
    public function __invoke(): Renderable
    {
        return view('kiosk.dashboard');
    }
}
