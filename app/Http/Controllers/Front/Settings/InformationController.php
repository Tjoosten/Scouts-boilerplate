<?php

namespace App\Http\Controllers\Front\Settings;

use App\Actions\Users\UpdateUserAction;
use App\DataTransferObjects\UserInformationObject;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\InformationSettingsRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function index(Request $request): Renderable
    {
        return view('auth.settings.information', ['user' => $request->user()]);
    }

    public function update(InformationSettingsRequest $request, UpdateUserAction $updateUserAction): RedirectResponse
    {
        $attributes = UserInformationObject::fromRequest($request)->except('password')->toArray();
        $informationUpdate = $updateUserAction->execute($request->user(), $attributes);

        session()->flash('informationUpdated', $informationUpdate);

        return redirect()->route('account.settings.information');
    }
}
