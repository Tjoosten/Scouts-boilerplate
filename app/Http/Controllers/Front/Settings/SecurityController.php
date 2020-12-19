<?php

namespace App\Http\Controllers\Front\Settings;

use App\Actions\Users\UpdateUserAction;
use App\DataTransferObjects\UserInformationObject;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\SecuritySettingsRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SecurityController extends Controller
{
    public function index(Request $request): Renderable
    {
        return view('auth.settings.security', ['user' => $request->user()]);
    }

    public function update(SecuritySettingsRequest $request, UpdateUserAction $updateUserAction): RedirectResponse
    {
        $attributes = UserInformationObject::fromRequest($request)->only('password')->toArray();
        $securityUpdate = $updateUserAction->execute($request->user(), $attributes);

        session()->flash('securityUpdated', ['success' => $securityUpdate]);

        return redirect()->route('account.settings.security');
    }
}
