<?php

namespace App\Notifications\Teams;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Mpociot\Teamwork\TeamInvite;

/**
 * @todo Implement accept or reject routes in the mail view.
 */
class InvitationMail extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public TeamInvite $invite) {}

    public function via(): array
    {
        return ['mail'];
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->subject(__('Uitnodiging om je aan te sluiten bij de ploeg' . $this->invite->team->name))
            ->markdown('teams.mail.invitation', ['invite' => $this->invite]);
    }
}
