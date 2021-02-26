<?php

namespace App\Http\Controllers\Front\Settings;

use App\Actions\Users\DeleteUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\DeleteAccountRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    public function __invoke(DeleteAccountRequest $request, DeleteUserAction $deleteUserAction): RedirectResponse
    {
        $deleteUserAction->execute($request->user());

        return redirect()->route('login');
    }
}
