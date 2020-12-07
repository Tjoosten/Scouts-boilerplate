<?php

namespace App\Notifications\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

/**
 * Class AccountDeactivatedNotification
 *
 * @package App\Notifications\Users
 */
class AccountDeactivatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param  string $reason The reason why the user account in deactivated.
     * @return void
     */
    public function __construct(
        public string $reason
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via(): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @return MailMessage
     */
    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->subject(__('Uw account is gedeactiveerd'))
            ->markdown('mail.userDeactivatedNotification', ['reason' => $this->reason]);
    }
}
