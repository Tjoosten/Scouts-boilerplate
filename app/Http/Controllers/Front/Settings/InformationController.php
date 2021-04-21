<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front\Settings;

use App\Actions\Users\UpdateUserAction;
use App\DataTransferObjects\UserInformationObject;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\InformationSettingsRequest;
use Illuminate\Http\RedirectResponse;

/**
 * Class InformationController
 *
 * @package App\Http\Controllers\Front\Settings
 */
final class InformationController extends Controller
{
    /**
     * Method for update the information settings from the authenticated user in the application.
     *
     * @param  InformationSettingsRequest $request           The request validator instance.
     * @param  UpdateUserAction           $updateUserAction  The action that writes the changes to the database.
     * @return RedirectResponse
     */
    public function __invoke(InformationSettingsRequest $request, UpdateUserAction $updateUserAction): RedirectResponse
    {
        $attributes = UserInformationObject::fromRequest($request)->except('password')->toArray();
        $informationUpdate = $updateUserAction->execute($request->user(), $attributes);

        session()->flash('informationUpdated', $informationUpdate);

        return redirect()->route('account.settings.information');
    }
}
