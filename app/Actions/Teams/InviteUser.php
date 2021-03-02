<?php declare(strict_types=1);

namespace App\Actions\Teams;

use App\DataTransferObjects\UserInformationObject;

use App\Models\Team;
use App\Models\User;
use App\Notifications\Teams\InvitationMail;
use Mpociot\Teamwork\Facades\Teamwork;

final class InviteUser
{
    public function handle(Team $team, UserInformationObject $userInformationObject): void
    {
        $emailAddress = $userInformationObject->email;

        if ($this->isAuthenticatedUser($emailAddress)) {
            session()->flash('invitation', __('Je kunt jezelf niet uitnodigen voor de ploeg'));
            return;
        }

        if (! Teamwork::hasPendingInvite($emailAddress, $team)) {
            Teamwork::inviteToTeam($emailAddress, $team, function ($invite): void {
                $this->findUser($invite->email)->notify(new InvitationMail($invite));
                session()->flash('invitation', __('De gebruiker is met success uitgenodigd.'));
            });

            return;
        }

        session()->flash('invitation', __('De gebruiker is al uitgenodigd voor de ploeg'));
    }

    private function isAuthenticatedUser(string $email): bool
    {
        return $email === auth()->user()->email;
    }

    private function findUser(string $email): User
    {
        return User::whereEmail($email)->firstOrFail();
    }
}
