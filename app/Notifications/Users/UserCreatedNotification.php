<?php

namespace App\Notifications\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $password
    ) {}


    public function via(): string
    {
        return 'mail';
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage())
            ->subject(__('Er is een login aangemaakt voor u op :applicatie', ['applicatie' => config('app.name')]))
            ->greeting('Hallo,')
            ->line(__('Een administrator heeft een login aangemaakt voor u op :applicatie', ['applicatie' => config('app.name')]))
            ->line(__('U kunt aanmelden met je email adres en het volgende wachtwoord: ') . $this->password)
            ->action('login', route('login'));
    }
}
