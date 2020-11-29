<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;

/**
 * Class DashboardController
 *
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     * Method for displaying the home view when the user is authenticated in the application.
     * @return Renderable
     */
    public function __invoke(): Renderable
    {
        return view('home');
    }
}
