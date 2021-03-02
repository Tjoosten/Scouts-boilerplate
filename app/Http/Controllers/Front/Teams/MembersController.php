<?php declare(strict_types=1);

namespace App\Http\Controllers\Front\Teams;

use App\Actions\Teams\InviteUser;
use App\DataTransferObjects\UserInformationObject;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teams\InvitationFormRequest;
use App\Models\Team;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Class MembersController
 *
 * @todo Write phpunit tests
 * @package App\Http\Controllers\Front\Teams
 */
final class MembersController extends Controller
{
    /**
     * Method for displaying the member management console for the the given team.
     *
     * @param  Request $request The request instance that contains all the request information.
     * @param  Team    $team    The resource entity for the given team.
     * @return Renderable
     */
    public function index(Request $request, Team $team): Renderable
    {
        $teams = $request->user()->teams()->get(['id', 'name']);
        $invites = $team->getOpenInvites();
        $members = $team->getMembers();

        return view('teams.members.index', compact('team','invites', 'members', 'teams'));
    }

    public function store(InvitationFormRequest $request, Team $team, InviteUser $userInvitation): RedirectResponse
    {
        $userInvitation->handle($team, UserInformationObject::fromRequest($request)->only('email'));

        return redirect()->action([self::class, 'index'], $team);
    }
}
