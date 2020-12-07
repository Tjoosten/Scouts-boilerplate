<?php

namespace App\Http\Controllers\Kiosk\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Cog\Laravel\Ban\Models\Ban;
use Illuminate\Contracts\Support\Renderable;

/**
 * Class LockController
 *
 * @package App\Http\Controllers\Kiosk\Users
 */
class LockController extends Controller
{
    /**
     * LockController constructor.
     *
     * @param  UserService $userService The abstraction layer for all the logic that is related to the users.
     * @return void
     */
    public function __construct(
        private UserService $userService
    ) {}

    /**
     * Method for displaying the deactivation view for the given user.
     *
     * @param  User $user The resource entity from the given user.
     * @return Renderable
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(User $user): Renderable
    {
        $this->authorize('deactivate', $user);

        return view('kiosk.users.deactivate', compact('user'));
    }
}
