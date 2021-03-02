<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Mpociot\Teamwork\TeamworkTeam;

/**
 * @method static create(array $array)
 */
class Team extends TeamworkTeam
{
    use HasFactory;

    public function createDefaultTeam(User $user, string $name): self
    {
        $team = self::create(['name' => $name, 'owner_id' => $user->getKey()]);
        $user->attachTeam($team);

        return $team;
    }

    public function getOpenInvites(): LengthAwarePaginator
    {
        return $this->invites()->paginate();
    }

    public function getMembers(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->users()->withPivot('created_at')->paginate();
    }
}
