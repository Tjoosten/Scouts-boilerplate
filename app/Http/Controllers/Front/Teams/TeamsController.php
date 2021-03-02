<?php declare(strict_types=1);

namespace App\Http\Controllers\Front\Teams;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

/**
 * Class TeamsController
 *
 * @todo Write unit tests
 * @package App\Http\Controllers
 */
final class TeamsController extends Controller
{
    /**
     * Method for displaying the current active team for the user.
     *
     * @param  Request  $request The request instance that contains all the request information.
     * @param  Team     $team    The resource entity for the current active team.
     * @return Renderable
     */
    public function show(Request $request, Team $team): Renderable
    {
        $teams = $request->user()->teams()->get(['id', 'name']);

        return view('teams.show', compact('team', 'teams'));
    }
}
