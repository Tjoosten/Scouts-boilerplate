<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;

/**
 * Class WelcomeController
 *
 * @package App\Http\Controllers
 */
class WelcomeController extends Controller
{
    /**
     * Method for displaying the welcome page from the application.
     *
     * @return Renderable
     */
    public function __invoke(): Renderable
    {
        return view('welcome');
    }
}
