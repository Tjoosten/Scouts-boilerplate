<?php

namespace App\Http\Controllers\Kiosk\Users;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request, UserService $userService): Renderable
    {
        return view('kiosk.users.index', [
            'users' => $userService->searchUsers($request->get('term'))
        ]);
    }
}
