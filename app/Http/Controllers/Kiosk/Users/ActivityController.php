<?php

namespace App\Http\Controllers\Kiosk\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function __invoke(User $user): Renderable
    {
        return view('kiosk.activities.show', [
            'user' => $user,
            'activities' => $user->actions()->latest()->paginate(15, ['log_name', 'description', 'created_at'])
        ]);
    }
}
