<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use stdClass;

/**
 * Class UserSessionService
 *
 * @package App\Services
 */
class UserSessionService
{
    /**
     * Method for getting all the session properties in the application.
     *
     * @return Collection
     */
    public function getProperties(): Collection
    {
        if ($this->isNotUsingDatabaseTable()) {
            return collect();
        }

        return $this->getUserSessions()->map(fn($session) => (object) [
            'agent' => $this->createAgent($session),
            'ip_address' => $session->ip_address,
            'is_current_device' => $session->id === request()->session()->getId(),
            'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
        ]);
    }

    /**
     * Method for determining if the session driver is the database driver.
     *
     * @return bool
     */
    private function isNotUsingDatabaseTable(): bool
    {
        return config('session.driver') !== 'database';
    }

    /**
     * Method for getting all the authentication sessions from the authenticated user.
     *
     * @return Collection
     */
    private function getUserSessions(): Collection
    {
        return DB::connection(config('session.connection'))->table($this->sessionDatabaseTable())
            ->where('user_id', Auth::user()->getAuthIdentifier())
            ->orderBy('last_activity', 'desc')
            ->get();
    }

    /**
     * Method for getting the database table name in the application.
     *
     * @return string
     */
    private function sessionDatabaseTable(): string
    {
        return config('session.table', 'sessions');
    }

    /**
     * Method for converting the session data to an Browser agent.
     *
     * @param  stdClass $session All the info from the given session.
     * @return Agent
     */
    private function createAgent(stdClass $session): Agent
    {
        return tap(new Agent, static function (Agent $agent) use ($session) {
            $agent->setUserAgent($session->user_agent);
        });
    }

    /**
     * Determine if the user has other sessions than the current authenticated session.
     *
     * @return bool
     */
    public function canLogoutOtherSession(): bool
    {
        return $this->otherSessions()->count() > 0;
    }

    /**
     * The query builder for getting all the current other user sessions.
     *
     * @return Builder
     */
    public function otherSessions(): Builder
    {
        return DB::connection(config('session.connection'))->table($this->sessionDatabaseTable())
            ->where('user_id', Auth::user()->getAuthIdentifier())
            ->where('id', '!=', request()->session()->getId());
    }

    /**
     * Method for logging all the browser sessions out and deleted them.
     *
     * @param  string $password The password that the user has filled in.
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function logoutOtherBrowserSessions(string $password): void
    {
        if ($this->sessionDatabaseTable() && ! $this->canLogoutOtherSession()) {
            return;
        }

        auth()->logoutOtherDevices($password);

        $this->otherSessions()->delete();
    }
}
