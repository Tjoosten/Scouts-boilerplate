<?php

namespace App\Http\Controllers\Kiosk\Users;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

/**
 * Class UsersController
 *
 * @package App\Http\Controllers\Kiosk\Users
 */
class UsersController extends Controller
{
    /**
     * UsersController constructor.
     *
     * @param  UserService $service Database abstraction layer that is related for the users.
     * @return void
     */
    public function __construct(
        private UserService $service
    ) {}

    /**
     * Method for displaying all the users in the application.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
       return view('kiosk.users.index', []);
    }
}
