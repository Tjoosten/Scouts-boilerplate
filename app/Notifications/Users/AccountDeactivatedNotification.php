<?php

namespace App\Notifications\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class AccountDeactivatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $reason // The reason why the user account is banned.
    ) {}

    public function via(): array
    {
        return ['mail'];
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->subject(__('Uw account is gedeactiveerd'))
            ->markdown('mail.userDeactivatedNotification', ['reason' => $this->reason]);
    }
}
