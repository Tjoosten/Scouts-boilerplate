<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
}
