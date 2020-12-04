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
     * @param  UserService $userService Database abstraction layer that is related for the users.
     * @return void
     */
    public function __construct(
        private UserService $userService
    ) {}

    /**
     * Method for displaying all the users in the application.
     *
     * @param  string|null $filter The filter to apply on the users from the database.
     * @return Renderable
     */
    public function index(string|null $filter = null): Renderable
    {
       return view('kiosk.users.index', ['users' => $this->userService->getUsers($filter)]);
    }
}
